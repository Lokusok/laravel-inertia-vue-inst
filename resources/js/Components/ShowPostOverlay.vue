<script setup>
import { ref, toRefs } from "vue";
import { usePage } from "@inertiajs/vue3";

import ShowPostOptionsOverlay from "@/Components/ShowPostOptionsOverlay.vue";
import LikesSection from "./LikesSection.vue";

import Close from "vue-material-design-icons/Close.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import EmoticonHappyOutline from "vue-material-design-icons/EmoticonHappyOutline.vue";

const props = defineProps({
    post: Object,
});

const emit = defineEmits([
    "closeOverlay",
    "addComment",
    "updateLike",
    "deleteSelected",
]);

const textareaInput = (event) => {
    textareaNode.value.style.height = "auto";
    textareaNode.value.style.height = `${event.target.scrollHeight}px`;
};

const { post } = toRefs(props);

const textareaNode = ref(null);
const comment = ref("");
const deleteType = ref(true);
const id = ref(null);

// const user = usePage().props.auth.user;
</script>

<template>
    <div
        id="overlaySection"
        class="fixed z-50 top-0 left-0 w-full h-screen bg-[#000000] bg-opacity-60 p-3"
    >
        <button class="absolute right-3" @click="$emit('closeOverlay')">
            <Close :size="27" fill-color="#ffffff" />
        </button>

        <div
            class="max-w-6xl h-[calc(100%-100px)] mx-auto mt-10 bg-white rounded-xl"
        >
            <div class="w-full h-full overflow-auto md:flex rounded-xl">
                <div class="flex items-center w-full bg-black">
                    <img
                        class="rounded-xl min-w-[400px] p-4 mx-auto"
                        src="https://placehold.co/400x400"
                    />
                </div>

                <div class="md:max-w-[500px] w-full relative">
                    <div class="flex items-center justify-between p-3 border-b">
                        <div class="flex items-center">
                            <img
                                class="rounded-full w-[38px] h-[38px]"
                                src="https://placehold.co/400x400"
                            />
                            <div class="ml-4 font-extrabold text-[15px]">
                                NAME HERE
                            </div>
                            <div
                                class="flex items-center text-[15px] text-gray-500"
                            >
                                <span class="-mt-5 ml-2 mr-[5px] text-[35px]">
                                    .
                                </span>
                                <div>DATE HERE</div>
                            </div>
                        </div>

                        <button>
                            <DotsHorizontal :size="27" class="cursor-pointer" />
                        </button>
                    </div>

                    <div class="overflow-y-auto h-[calc(100%-170px)]">
                        <div class="flex items-center justify-between p-3">
                            <div class="relative flex items-center">
                                <img
                                    class="absolute -top-1 rounded-full w-[38px] h-[38px]"
                                    src="https://placehold.co/400x400"
                                />
                                <div class="ml-14">
                                    <span
                                        class="font-extrabold text-[15px] mr-2"
                                    >
                                        NAME HERE
                                    </span>

                                    <span class="text-[15px] text-gray-900">
                                        THIS IS A COMMENT
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img
                                        class="rounded-full w-[38px] h-[38px]"
                                        src="https://placehold.co/400x400"
                                    />
                                    <div
                                        class="ml-4 font-extrabold text-[15px]"
                                    >
                                        NAME HERE
                                        <span
                                            class="text-sm font-light text-gray-700"
                                        >
                                            DATE HERE
                                        </span>
                                    </div>
                                </div>

                                <DotsHorizontal
                                    :size="27"
                                    class="cursor-pointer"
                                />
                            </div>

                            <div class="text-[13px] pl-[55px]">
                                THIS COMMENT SECTION
                            </div>
                        </div>

                        <div class="pb-16 md:hidden"></div>
                    </div>

                    <LikesSection class="px-2 mb-2 border-t" />

                    <div
                        class="absolute flex border bottom-0 w-full max-h-[200px] bg-white overflow-auto"
                    >
                        <EmoticonHappyOutline
                            :size="30"
                            class="pl-3 pt-[10px]"
                        />

                        <textarea
                            v-model="comment"
                            ref="textareaNode"
                            @input="textareaInput"
                            placeholder="Add a comment..."
                            rows="1"
                            class="w-full border-0 mt-2 mb-2 text-sm z-50 focus:ring-0 text-gray-600 text-[18px] resize-none"
                        ></textarea>

                        <button
                            v-if="comment"
                            class="pr-4 font-extrabold text-blue-600"
                        >
                            Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ShowPostOptionsOverlay v-if="deleteType" :delete-type="deleteType" />
</template>
