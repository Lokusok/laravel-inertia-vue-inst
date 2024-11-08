<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

import Magnify from "vue-material-design-icons/Magnify.vue";
import HeartOutline from "vue-material-design-icons/HeartOutline.vue";
import HomeOutline from "vue-material-design-icons/HomeOutline.vue";
import Compass from "vue-material-design-icons/Compass.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import AccountOutline from "vue-material-design-icons/AccountOutline.vue";
import ChevronLeft from "vue-material-design-icons/ChevronLeft.vue";
import AccoutPlusOutline from "vue-material-design-icons/AccountPlusOutline.vue";

import MenuItem from "@/Components/MenuItem.vue";
import CreatePostOverlay from "@/Components/CreatePostOverlay.vue";

const showCreatePost = ref(false);

const enableCreatingPost = () => {
    showCreatePost.value = true;
};

const disableCreatingPost = () => {
    showCreatePost.value = false;
};
</script>

<template>
    <div id="MainLayout" class="w-full h-screen">
        <!-- Mobile menu -->
        <div
            v-if="$page.url === '/'"
            id="TopNavHome"
            class="fixed z-30 md:hidden block w-full bg-white h-[61px] border-b border-b-gray-300"
        >
            <div class="flex items-center justify-between h-full">
                <Link href="/">
                    <img
                        class="w-[105px] ml-6 cursor-pointer"
                        src="/insta-logo.png"
                    />
                </Link>

                <div class="flex items-center w-[50%]">
                    <div
                        class="flex items-center w-full bg-gray-100 rounded-lg"
                    >
                        <Magnify class="pl-4" fill-color="#8e8e8e" :size="27" />
                        <input
                            type="text"
                            placeholder="Search"
                            class="bg-transparent w-full placeholder-[#8e8e8e] border-0 ring-0 focus:ring-0"
                        />
                    </div>

                    <HeartOutline
                        class="pl-4 pr-3"
                        fill-color="#000000"
                        :size="27"
                    />
                </div>
            </div>
        </div>

        <!-- For user page in the future -->
        <div
            v-if="$page.url !== '/'"
            id="TopNavUser"
            class="md:hidden fixed flex items-center justify-between z-30 w-full bg-white h-[61px] border-b border-b-gray-300"
        >
            <Link href="/" class="px-4">
                <ChevronLeft :size="30" class="cursor-pointer" />
            </Link>

            <div class="text-lg font-extrabold">NAME HERE</div>

            <AccoutPlusOutline :size="30" class="px-4 cursor-pointer" />
        </div>

        <!-- Sidebar -->
        <div
            id="SideNav"
            class="fixed h-full bg-white xl:w-[280px] w-[80px] md:block hidden border-r border-r-gray-300"
        >
            <Link>
                <img
                    class="xl:hidden block w-[25px] mt-10 ml-[25px] mb-10 cursor-pointer"
                    src="/insta-logo-small.png"
                />
                <img
                    class="xl:block hidden w-[120px] mt-10 ml-6 mb-10 cursor-pointer"
                    src="/insta-logo.png"
                />
            </Link>

            <div class="px-3">
                <Link href="/">
                    <MenuItem icon-string="Home" class="mb-4" />
                </Link>
                <MenuItem icon-string="Search" class="mb-4" />
                <MenuItem icon-string="Explore" class="mb-4" />
                <MenuItem icon-string="Messages" class="mb-4" />
                <MenuItem icon-string="Notifications" class="mb-4" />
                <MenuItem
                    icon-string="Create"
                    class="mb-4"
                    @click="enableCreatingPost"
                />
                <Link href="/">
                    <MenuItem icon-string="Profile" class="mb-4" />
                </Link>
            </div>

            <Link href="/" class="absolute bottom-0 w-full px-3">
                <MenuItem icon-string="Log out" class="mb-4" />
            </Link>
        </div>

        <div
            class="flex lg:justify-between bg-white h-full w-[100%-280px] xl:pl-[280px] pl-[100px] overflow-auto"
        >
            <div
                class="pt-20 mx-auto md:pt-6"
                :class="{
                    'lg:w-8/12 w-full': $page.url === '/',
                    'max-w-[1200px]': $page.url !== '/',
                }"
            >
                <main>
                    <slot />
                </main>
            </div>

            <!-- Suggestions -->
            <div
                v-if="$page.url === '/'"
                id="SuggestionSection"
                class="hidden mt-10 text-black lg:w-4/12 lg:block"
            >
                <Link
                    href="/"
                    class="flex items-center justify-between max-w-[300px]"
                >
                    <div class="flex items-center">
                        <img
                            class="rounded-full z-10 w-[58px] h-[58px]"
                            src="https://placehold.co/200x200"
                        />
                        <div class="pl-4">
                            <div class="font-extrabold text-black">
                                NAME HERE
                            </div>
                            <div class="text-sm text-gray-500 text-extrabold">
                                NAME HERE
                            </div>
                        </div>
                    </div>

                    <button
                        class="text-xs font-extrabold text-blue-500 hover:text-gray-900"
                    >
                        Switch
                    </button>
                </Link>

                <div
                    class="max-w-[300px] flex items-center justify-between py-3"
                >
                    <div class="font-extrabold text-gray-500">
                        Suggestions for you
                    </div>
                    <button
                        class="text-xs font-extrabold text-blue-500 hover:text-gray-900"
                    >
                        See all
                    </button>
                </div>

                <!-- In future, we will grab the users from DB and loop through the users array -->
                <Link
                    class="flex items-center justify-between max-w-[300px] pb-2"
                    href="/"
                >
                    <div class="flex items-center">
                        <img
                            class="rounded-full z-10 w-[37px] h-[37px]"
                            src="https://placehold.co/200x200"
                        />
                        <div class="pl-4">
                            <div class="font-extrabold text-black">
                                NAME HERE
                            </div>
                            <div class="text-sm text-gray-500 text-extrabold">
                                NAME HERE
                            </div>
                        </div>
                    </div>

                    <button
                        class="text-xs font-extrabold text-blue-500 hover:text-gray-900"
                    >
                        Follow
                    </button>
                </Link>

                <div class="max-w-[300px] mt-5">
                    <div class="text-sm text-gray-400">
                        About Help press API Jobs Privacy Terms Locations
                        Language Meta verification
                    </div>
                    <div class="mt-4 text-left text-gray-400">
                        &copy; 2024 INSTAGRAM FROM META
                    </div>
                </div>
            </div>
        </div>

        <div
            id="BottomNav"
            class="fixed bottom-0 z-30 flex items-center justify-around w-full bg-white border-t md:hidden border-t-gray-300"
        >
            <Link href="/">
                <HomeOutline
                    fill-color="#000000"
                    :size="33"
                    class="cursor-pointer"
                />
            </Link>
            <Compass fill-color="#000000" :size="33" class="cursor-pointer" />
            <Compass fill-color="#000000" :size="33" class="cursor-pointer" />
            <Plus
                @click="enableCreatingPost"
                fill-color="#000000"
                :size="33"
                class="cursor-pointer"
            />
            <AccountOutline
                fill-color="#000000"
                :size="33"
                class="cursor-pointer"
            />
            <Link href="/">
                <img
                    class="rounded-full w-[30px] cursor-pointer"
                    src="https://placehold.co/300x320"
                />
            </Link>
        </div>
    </div>

    <CreatePostOverlay v-if="showCreatePost" @close="disableCreatingPost" />
</template>
