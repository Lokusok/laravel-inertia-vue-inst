<script setup>
import { ref, reactive } from "vue";
import { router, usePage } from "@inertiajs/vue3";

import Close from "vue-material-design-icons/Close.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import MapMarkerOutline from "vue-material-design-icons/MapMarkerOutline.vue";
import ChevronDown from "vue-material-design-icons/ChevronDown.vue";

const user = usePage().props.auth.user;

const emit = defineEmits(["close"]);

const form = reactive({
    text: null,
    file: null,
});

const isValidFile = ref(null);
const fileDisplay = ref("");
const textareaNode = ref("");
const error = ref({
    text: null,
    file: null,
});

const closeOverlay = () => {
    form.text = null;
    form.file = null;
    fileDisplay.value = "";
    emit("close");
};

const createPost = () => {
    error.value.text = null;
    error.value.file = null;

    router.post("/posts", form, {
        forceFormData: true,
        preserveScroll: true,
        onError: (errors) => {
            if (errors?.text) error.value.text = errors.text;
            else error.value.text = "";

            if (errors?.file) error.value.file = errors.file;
            else error.value.file = "";
        },
        onSuccess: () => {
            closeOverlay();
        },
    });
};

const getUploadedImage = (event) => {
    form.file = event.target.files[0];

    const extension = form.file.name.substring(
        form.file.name.lastIndexOf(".") + 1
    );

    const allowedExtensions = ["png", "jpg", "jpeg"];

    isValidFile.value = allowedExtensions.includes(extension);

    if (!isValidFile.value) {
        return;
    }

    fileDisplay.value = URL.createObjectURL(form.file);

    setTimeout(() => {
        document.getElementById("TextAreaSection").scrollIntoView({
            behavior: "smooth",
        });
    }, 300);
};
</script>

<template>
    <div
        id="overlaySection"
        class="fixed z-50 top-0 left-0 w-full h-screen bg-[#000000] bg-opacity-60 p-3"
    >
        <button class="absolute cursor-pointer right-3" @click="closeOverlay">
            <Close :size="27" fill-color="#ffffff" />
        </button>

        <div
            class="max-w-6xl h-[calc(100%-100px)] mx-auto mt-10 bg-white rounded-xl"
        >
            <div
                class="flex items-center justify-between w-full p-3 border-b rounded-t-xl border-b-gray-300"
            >
                <button @click="closeOverlay">
                    <ArrowLeft :size="30" fill-color="#000000" />
                </button>

                <div class="text-lg font-extrabold">New reel</div>

                <button
                    class="text-lg font-extrabold text-blue-500 hover:text-gray-900"
                    @click="createPost"
                >
                    Share
                </button>
            </div>

            <div
                class="w-full md:flex h-[calc(100%-55px)] rounded-xl overflow-auto"
            >
                <div
                    class="flex items-center w-full h-full overflow-hidden bg-gray-100"
                >
                    <div
                        v-if="!fileDisplay"
                        class="flex flex-col items-center mx-auto"
                    >
                        <label
                            for="file"
                            class="bg-blue-500 hover:bg-blue-700 rounded lg p-2.5 text-white font-extrabold cursor-pointer"
                        >
                            Select From Computer
                        </label>
                        <input
                            id="file"
                            class="hidden"
                            type="file"
                            @input="getUploadedImage"
                        />
                        <div
                            v-if="error && error.file"
                            class="p-2 font-extrabold text-center text-red-500"
                        >
                            {{ error.file }}
                        </div>
                        <div
                            v-if="!fileDisplay && isValidFile === false"
                            class="p-2 font-extrabold text-center text-red-500"
                        >
                            File not accepted
                        </div>
                    </div>

                    <!-- File preview -->
                    <img
                        v-if="fileDisplay && isValidFile === true"
                        class="min-w-[400px] max-h-[90%] object-cover p-4 mx-auto"
                        :src="fileDisplay"
                    />
                </div>

                <div id="TextAreaSection" class="max-w-[720px] w-full relative">
                    <div class="flex items-center justify-between p-3">
                        <div class="flex items-center">
                            <img
                                class="rounded-full w-[38px] h-[38px]"
                                src="https://placehold.co/200x200"
                                alt=""
                            />
                            <div class="ml-4 font-extrabold text-[15px]">
                                NAME HERE
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="error && error.text"
                        class="p-2 font-extrabold text-red-500"
                    >
                        {{ error.text }}
                    </div>

                    <div class="flex w-full max-h-[200px] bg-white border-b">
                        <textarea
                            v-model="form.text"
                            ref="textareaNode"
                            placeholder="Write caption..."
                            rows="10"
                            class="z-50 w-full mt-2 mb-2 text-gray-600 placeholder-gray-500 border-0 focus:ring-0 text-[18px]"
                        ></textarea>
                    </div>

                    <div class="flex items-center justify-between p-3 border-b">
                        <div class="text-lg font-extrabold text-gray-500">
                            Add location
                        </div>
                        <MapMarkerOutline :size="27" />
                    </div>

                    <div class="flex items-center justify-between p-3 border-b">
                        <div class="text-lg font-extrabold text-gray-500">
                            Accessibility
                        </div>
                        <ChevronDown :size="27" />
                    </div>

                    <div class="flex items-center justify-between p-3 border-b">
                        <div class="text-lg font-extrabold text-gray-500">
                            Advanced Settings
                        </div>
                        <ChevronDown :size="27" />
                    </div>

                    <div class="p-3 mt-3 text-sm text-gray-500">
                        Your reel will be shared with your followers in their
                        feeds and can be seen on your profile. It may also
                        appear in places such as Reels, where anyone can see it.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
