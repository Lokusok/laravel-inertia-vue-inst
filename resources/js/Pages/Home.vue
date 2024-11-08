<script setup>
import { ref, onMounted, toRefs } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

import LikesSection from "@/Components/LikesSection.vue";
import ShowPostOverlay from "@/Components/ShowPostOverlay.vue";

import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Navigation } from "vue3-carousel";

import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";

const props = defineProps({
    posts: Object,
    allUsers: Object,
});

const { posts, allUsers } = toRefs(props);

const user = usePage().props.auth.user;

const wWidth = ref(window.innerWidth);

const currentSlide = ref(0);
const currentPost = ref(null);
const openOverlay = ref(false);

onMounted(() => {
    window.addEventListener("resize", () => {
        wWidth.value = window.innerWidth;
    });
});

const activateOverlay = (post) => {
    currentPost.value = post;
    openOverlay.value = true;
};

const disableOverlay = () => {
    openOverlay.value = false;
};

const updateLike = (newLike) => {
    let deleteLike = false;
    let id = null;

    console.log(newLike);

    for (let i = 0; i < newLike.post.likes.length; i++) {
        const like = newLike.post.likes[i];

        if (like.user_id === user.id && like.post_id === newLike.post.id) {
            deleteLike = true;
            id = like.id;
        }
    }

    if (deleteLike) {
        router.delete(`/likes/${id}`, {
            onFinish: () => updatePost(newLike),
        });
    } else {
        router.post(
            "/likes",
            {
                post_id: newLike.post.id,
            },
            {
                onFinish: () => updatePost(newLike),
            }
        );
    }
};

const addComment = (newComment) => {
    const comment = {
        post_id: newComment.post.id,
        user_id: newComment.user.id,
        comment: newComment.comment,
    };

    router.post("/comments", comment, {
        onFinish: () => updatePost(newComment),
    });
};

const deleteSelected = () => {
    openOverlay.value = false;
};

const updatePost = (newPost) => {
    for (let i = 0; i < posts.value.data.length; i++) {
        const post = posts.value.data[i];

        if (post.id === newPost.post.id) {
            currentPost.value = post;
        }
    }
};
</script>

<template>
    <Head title="Instagram" />

    <MainLayout>
        <div class="mx-auto lg:pl-0 md:pl-[80px] pl-0">
            <Carousel
                v-model="currentSlide"
                class="max-w-[700px] mx-auto"
                :items-to-show="width >= 768 ? 8 : 6"
                :items-to-scroll="4"
                :wrap-around="true"
                :transition="500"
                snap-align="start"
            >
                <Slide v-for="user in allUsers" :key="user.id">
                    <Link
                        :href="route('users.show', { id: user.id })"
                        class="relative px-2 mx-auto mt-4 text-center cursor-pointer"
                    >
                        <div
                            class="absolute z-[-1] -top-[5px] left-[4px] rounded-full rotate-45 w-[64px] h-[64px] contrast-[1.3] bg-gradient-to-t from-yellow-300 to-purple-500 via-red-500"
                        >
                            <div
                                class="rounded-full ml-[3px] mt-[3px] w-[58px] h-[58px] bg-white"
                            />
                        </div>
                        <img
                            :src="user.file"
                            class="rounded-full w-[56px] h-[56px] -mt-[1px]"
                        />
                        <div
                            class="text-xs mt-2 w-[60px] truncate text-ellipsis overflow-hidden"
                        >
                            {{ user.name }}
                        </div>
                    </Link>
                </Slide>

                <template #addons>
                    <Navigation />
                </template>
            </Carousel>

            <!-- Posts list -->
            <div
                v-for="post in posts.data"
                :key="post.id"
                id="Posts"
                class="px-4 max-w-[600px] mx-auto mt-10"
            >
                <div class="flex items-center justify-between py-2">
                    <div class="flex items-center">
                        <Link
                            :href="route('users.show', { id: post.user.id })"
                            class="flex items-center"
                        >
                            <img
                                :src="post.user.file"
                                class="rounded-full w-[38px] h-[38px]"
                            />
                            <div class="ml-4 font-extrabold text-[15px]">
                                {{ post.user.name }}
                            </div>
                        </Link>
                        <div
                            class="flex items-center text-[15px] text-gray-500"
                        >
                            <span class="-mt-5 ml-2 mr-[5px] text-[35px]">
                                .
                            </span>

                            <div>{{ post.created_at }}</div>
                        </div>
                    </div>

                    <DotsHorizontal :size="27" class="cursor-pointer" />
                </div>

                <div
                    class="bg-black rounded-lg w-full min-h-[400px] flex items-center"
                >
                    <img :src="post.file" class="w-full mx-auto" />
                </div>

                <LikesSection v-if="post" :post="post" @like="updateLike" />

                <div class="py-1 font-extrabold text-black">
                    {{ post.likes.length }} likes
                </div>
                <div>
                    <span class="font-extrabold text-black">
                        {{ post.user.name }}
                    </span>
                    <span>{{ post.text }}</span>
                </div>

                <button
                    class="py-1 font-extrabold text-gray-500"
                    @click="activateOverlay(post)"
                >
                    View all {{ post.comments.length }} comments
                </button>
            </div>

            <div class="pb-20"></div>
        </div>
    </MainLayout>

    <ShowPostOverlay
        v-if="openOverlay"
        :post="currentPost"
        @add-comment="addComment"
        @update-like="updateLike"
        @delete-selected="deleteSelected"
        @close-overlay="disableOverlay"
    />
</template>

<style>
.carousel__prev,
.carousel__next {
    color: rgb(49, 49, 49);
    background-color: rgb(255, 255, 255);
    border-radius: 100%;
    margin: 0 20px;
    transition: opacity ease 0.7;
}

.carousel__prev:hover,
.carousel__next:hover {
    opacity: 0.9;
}

.carousel__prev:active,
.carousel__next:active {
    opacity: 0.6;
}
</style>
