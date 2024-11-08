<script setup>
import { computed, toRefs, toValue } from "vue";
import { usePage } from "@inertiajs/vue3";

import Heart from "vue-material-design-icons/Heart.vue";
import HeartOutline from "vue-material-design-icons/HeartOutline.vue";
import CommentOutline from "vue-material-design-icons/CommentOutline.vue";
import SendOutline from "vue-material-design-icons/SendOutline.vue";
import BookmarkOutline from "vue-material-design-icons/BookmarkOutline.vue";

const props = defineProps({
    post: Object,
});

const { post } = toRefs(props);

const emit = defineEmits(["like"]);

const user = usePage().props.auth.user;

const isHeartActive = computed(() => {
    for (let i = 0; i < post.value.likes.length; i++) {
        const like = post.value.likes[i];

        if (like.user_id === user.id && like.post_id === post.value.id) {
            return true;
        }
    }

    return false;
});

const handleLikeClick = () => {
    emit("like", {
        post: toValue(post),
        user: toValue(user),
    });
};
</script>

<template>
    <div class="z-20 flex items-center justify-between">
        <div class="flex items-center">
            <button class="-mt-[14px]" @click="handleLikeClick">
                <HeartOutline
                    v-if="!isHeartActive"
                    :size="30"
                    class="pl-3 cursor-pointer"
                />
                <Heart
                    v-else
                    :size="30"
                    class="pl-3 cursor-pointer"
                    fill-color="#ff0000"
                />
            </button>
            <CommentOutline :size="30" class="pl-3 pt-[10px]" />
            <SendOutline :size="30" class="pl-3 pt-[10px]" />
        </div>

        <BookmarkOutline :size="30" class="pl-3 pt-[10px]" />
    </div>
</template>
