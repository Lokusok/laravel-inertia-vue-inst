<script setup>
import { ref, toRefs } from "vue";

import Heart from "vue-material-design-icons/Heart.vue";
import Comment from "vue-material-design-icons/Comment.vue";

const props = defineProps({
    postByUser: Object,
});

const emit = defineEmits(["selectedPost"]);

const { postByUser } = toRefs(props);

const isHover = ref(false);
</script>

<template>
    <div
        class="relative flex items-center justify-center cursor-pointer"
        @mouseenter="isHover = true"
        @mouseleave="isHover = false"
        @click="$emit('selectedPost', postByUser)"
    >
        <div
            v-if="isHover"
            :class="isHover ? 'bg-black bg-opacity-40' : ''"
            class="absolute z-50 flex items-center justify-around w-full h-full text-lg font-extrabold text-white"
        >
            <div class="flex items-center justify-around w-[50%]">
                <div class="flex items-center justify-center">
                    <Heart :size="30" fill-color="#ffffff" />
                    <div class="pl-1">{{ postByUser.likes.length }}</div>
                </div>

                <div class="flex items-center justify-center">
                    <Comment :size="30" fill-color="#ffffff" />
                    <div class="pl-1">{{ postByUser.comments.length }}</div>
                </div>
            </div>
        </div>

        <img
            :src="postByUser.file"
            class="z-0 object-cover w-full h-full mx-auto cursor-pointer aspect-square"
        />
    </div>
</template>
