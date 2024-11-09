<script setup>
import { reactive, toRefs } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";

import Cog from "vue-material-design-icons/Cog.vue";
import Grid from "vue-material-design-icons/Grid.vue";
import PlayBoxOutline from "vue-material-design-icons/PlayBoxOutline.vue";
import BookmarkOutline from "vue-material-design-icons/BookmarkOutline.vue";
import AccountBoxOutline from "vue-material-design-icons/AccountBoxOutline.vue";

import ContentOverlay from "@/Components/ContentOverlay.vue";
import ShowPostOverlay from "@/Components/ShowPostOverlay.vue";

const data = reactive({ post: null });
const form = reactive({ file: null });

const props = defineProps({
    postsByUser: Object,
    user: Object,
});

const { postsByUser, user } = toRefs(props);

const getUploadedImage = (event) => {
    form.file = event.target.files[0];

    router.post("/users", form, {
        preserveState: true,
    });
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

const deleteSelected = (entity) => {
    let url = "";

    if (entity.deleteType === "Post") {
        url = `/posts/${entity.id}`;
        setTimeout(() => (data.post = null), 100);
    } else {
        url = `/comments/${entity.id}`;
    }

    router.delete(url, {
        onFinish: () => updatePost(entity),
    });
};

const updateLike = (newLike) => {
    let deleteLike = false;
    let id = null;

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

const updatePost = (newPost) => {
    for (let i = 0; i < postsByUser.value.data.length; i++) {
        const post = postsByUser.value.data[i];

        if (post.id === newPost.post.id) {
            data.post = post;
        }
    }
};
</script>

<template>
    <Head title="Instagram" />

    <MainLayout>
        <div class="pt-2 md:pt-6"></div>
        <div class="max-w-[880px] lg:ml-0 md:ml-[80px] md:pl-20 px-4 w-[100vw]">
            <div class="flex items-center md:justify-between">
                <label for="fileUser">
                    <img
                        :src="user.file"
                        class="rounded-full object-fit md:w-[200px] w-[100px] cursor-pointer"
                    />
                </label>
                <input
                    v-if="user.id === $page.props.auth.user.id"
                    id="fileUser"
                    class="hidden"
                    type="file"
                    @input="getUploadedImage"
                />

                <div class="w-full ml-6">
                    <div class="flex items-center mb-5 md:mb-8">
                        <div class="md:mr-6 mr-3 rounded-lg text-[22px]">
                            {{ user.name }}
                        </div>
                        <button
                            class="md:block hidden md:mr-6 p-1 px-4 rounded-lg text-[16px] font-extrabold bg-gray-100 hover:bg-gray-200"
                        >
                            Edit profile
                        </button>
                        <Cog :size="28" class="cursor-pointer" />
                    </div>
                    <button
                        class="md:hidden mr-6 p-1 px-4 max-w-[260px] w-full rounded-lg text-[17px] font-extrabold bg-gray-100 hover:bg-gray-200"
                    >
                        Edit Profile
                    </button>
                    <div class="hidden md:block">
                        <div class="flex items-center text-[18px] gap-x-5">
                            <div>
                                <span class="font-extrabold">
                                    {{ postsByUser.data.length }}
                                </span>
                                posts
                            </div>

                            <div>
                                <span class="font-extrabold">123</span>
                                followers
                            </div>

                            <div>
                                <span class="font-extrabold">456</span>
                                following
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:hidden">
            <div
                class="flex items-center justify-around w-full mt-8 border-t border-t-gray-300"
            >
                <div class="p-3 text-center">
                    <div class="font-extrabold">
                        {{ postsByUser.data.length }}
                    </div>
                    <div class="text-gray-400 font-semibold -mt-1.5">posts</div>
                </div>
                <div class="p-3 text-center">
                    <div class="font-extrabold">43</div>
                    <div class="text-gray-400 font-semibold -mt-1.5">
                        followers
                    </div>
                </div>
                <div class="p-3 text-center">
                    <div class="font-extrabold">55</div>
                    <div class="text-gray-400 font-semibold -mt-1.5">
                        following
                    </div>
                </div>
            </div>

            <div
                class="flex items-center justify-between w-full border-t border-t-gray-300"
            >
                <div
                    class="flex justify-center w-1/4 p-3 border-t border-t-gray-900"
                >
                    <Grid
                        :size="28"
                        fill-color="#0095f6"
                        class="cursor-pointer"
                    />
                </div>

                <div class="flex justify-center w-1/4 p-3">
                    <PlayBoxOutline
                        :size="28"
                        fill-color="#8e8e8e"
                        class="cursor-pointer"
                    />
                </div>

                <div class="flex justify-center w-1/4 p-3">
                    <BookmarkOutline
                        :size="28"
                        fill-color="#8e8e8e"
                        class="cursor-pointer"
                    />
                </div>

                <div class="flex justify-center w-1/4 p-3">
                    <AccountBoxOutline
                        :size="28"
                        fill-color="#8e8e8e"
                        class="cursor-pointer"
                    />
                </div>
            </div>
        </div>

        <div id="ContentSection" class="md:pr-1.5 lg:pl-0 md:pl-[90px]">
            <div class="hidden mt-10 border-t md:block border-t-gray-300">
                <div
                    class="flex items-center justify-between max-w-[600px] mx-auto font-extrabold text-gray-400 text-[15px]"
                >
                    <div
                        class="p-[17px] w-1/4 flex justify-center items-center border-t border-t-gray-900"
                    >
                        <Grid
                            :size="15"
                            fill-color="#000000"
                            class="cursor-pointer"
                        />
                        <div class="ml-2 -mb-[1px] text-gray-900">POSTS</div>
                    </div>

                    <div
                        class="p-[17px] w-1/4 flex justify-center items-center"
                    >
                        <PlayBoxOutline
                            :size="15"
                            fill-color="#8e8e8e"
                            class="cursor-pointer"
                        />
                        <div class="ml-2 -mb-[1px] text-gray-900">REELS</div>
                    </div>

                    <div
                        class="p-[17px] w-1/4 flex justify-center items-center"
                    >
                        <BookmarkOutline
                            :size="15"
                            fill-color="#8e8e8e"
                            class="cursor-pointer"
                        />
                        <div class="ml-2 -mb-[1px]">SAVED</div>
                    </div>

                    <div
                        class="p-[17px] w-1/4 flex justify-center items-center"
                    >
                        <AccountBoxOutline
                            :size="15"
                            fill-color="#8e8e8e"
                            class="cursor-pointer"
                        />
                        <div class="ml-2 -mb-[1px]">TAGGED</div>
                    </div>
                </div>
            </div>

            <div class="relative grid grid-cols-3 gap-1 md:gap-4">
                <div
                    v-for="postByUser in postsByUser.data"
                    :key="postByUser.id"
                >
                    <ContentOverlay
                        :post-by-user="postByUser"
                        @selected-post="data.post = $event"
                    />
                </div>
            </div>

            <div class="pb-20" />
        </div>
    </MainLayout>

    <ShowPostOverlay
        v-if="data.post"
        :post="data.post"
        @add-comment="addComment"
        @update-like="updateLike"
        @delete-selected="deleteSelected"
        @close-overlay="data.post = null"
    />
</template>
