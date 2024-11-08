<script setup>
import { ref, onMounted, toRefs } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

import LikesSection from "@/Components/LikesSection.vue";

import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Navigation } from "vue3-carousel";

import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";

const props = defineProps({
    posts: Object,
    allUsers: Object,
});

const wWidth = ref(window.innerWidth);

const currentSlide = ref(0);
const currentPost = ref(null);
const openOverlay = ref(false);

onMounted(() => {
    window.addEventListener("resize", () => {
        wWidth.value = window.innerWidth;
    });
});
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
                <Slide v-for="slide in 10" :key="slide">
                    <Link
                        href="/"
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
                            class="rounded-full w-[56px] h-[56px] -mt-[1px]"
                            src="https://placehold.co/200x200"
                        />
                        <div
                            class="text-xs mt-2 w-[60px] truncate text-ellipsis overflow-hidden"
                        >
                            NAME HERE
                        </div>
                    </Link>
                </Slide>

                <template #addons>
                    <Navigation />
                </template>
            </Carousel>

            <div id="Posts" class="px-4 max-w-[600px] mx-auto mt-10">
                <div class="flex items-center justify-between py-2">
                    <div class="flex items-center">
                        <Link href="/" class="flex items-center">
                            <img
                                class="rounded-full w-[38px] h-[38px]"
                                src="https://placehold.co/200x200"
                            />
                            <div class="ml-4 font-extrabold text-[15px]">
                                NAME HERE
                            </div>
                        </Link>
                        <div
                            class="flex items-center text-[15px] text-gray-500"
                        >
                            <span class="-mt-5 ml-2 mr-[5px] text-[35px]">
                                .
                            </span>

                            <div>DATE HERE</div>
                        </div>
                    </div>

                    <DotsHorizontal :size="27" class="cursor-pointer" />
                </div>

                <div
                    class="bg-black rounded-lg w-full min-h-[400px] flex items-center"
                >
                    <img
                        class="w-full mx-auto"
                        src="https://placehold.co/200x200"
                    />
                </div>

                <LikesSection />

                <div class="py-1 font-extrabold text-black">3 likes</div>
                <div>
                    <span class="font-extrabold text-black">NAME HERE</span>
                    <span>this is some text here</span>
                </div>

                <button class="py-1 font-extrabold text-gray-500">
                    View all 4 comments
                </button>
            </div>

            <div class="pb-20"></div>
        </div>
    </MainLayout>
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
