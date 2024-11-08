<script setup>
import { computed, toRefs } from "vue";
import { usePage } from "@inertiajs/vue3";

import HomeOutline from "vue-material-design-icons/HomeOutline.vue";
import Magnify from "vue-material-design-icons/Magnify.vue";
import Compass from "vue-material-design-icons/Compass.vue";
import SendOutline from "vue-material-design-icons/SendOutline.vue";
import HeartOutline from "vue-material-design-icons/HeartOutline.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import AccountOutline from "vue-material-design-icons/AccountOutline.vue";
import Menu from "vue-material-design-icons/Menu.vue";

const props = defineProps({
    iconString: {
        type: String,
    },
});

const { iconString } = toRefs(props);

// const user = usePage().props.auth.user;

const isProfile = computed(() => {
    return props.iconString === "Profile";
});

const icon = computed(() => {
    switch (iconString.value) {
        case "Home":
            return HomeOutline;
        case "Search":
            return Magnify;
        case "Explore":
            return Compass;
        case "Messages":
            return SendOutline;
        case "Notifications":
            return HeartOutline;
        case "Create":
            return Plus;
        case "Profile":
            return AccountOutline;
        case "Log out":
            return Menu;
    }
});
</script>

<template>
    <div
        class="w-full p-2 transition duration-300 ease-in-out rounded-full cursor-pointer xl:inline-block xl:hover:bg-gray-100"
    >
        <div class="flex items-center">
            <img
                v-if="isProfile"
                :class="{
                    'mr-1': isProfile,
                }"
                class="rounded-full ml-[2px] w-[30px] cursor-pointer"
                src="https://placehold.co/300x320"
            />
            <component v-else :is="icon" fill-color="#0000000" :size="36" />
            <span
                class="xl:block hidden text-black font-extrabold text-[18px] pl-2 mt-0.5"
            >
                {{ iconString }}
            </span>
        </div>
    </div>
</template>
