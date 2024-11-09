<script setup>
import { toRefs } from "vue";

const props = defineProps({
    deleteType: String,
    id: Number,
});

const emit = defineEmits(["close", "deleteSelected"]);

const { id, deleteType } = toRefs(props);

const handleDeleteClick = () => {
    emit("deleteSelected", { id, deleteType });
};
</script>

<template>
    <div
        id="ShowPostOptionsOverlay"
        class="fixed flex items-center z-50 top-0 left-0 w-full h-screen bg-[#000000] bg-opacity-60 p-3"
    >
        <div
            class="w-full max-w-sm mx-auto mt-10 text-center bg-white rounded-xl"
        >
            <button
                class="w-full p-3 text-lg font-extrabold text-red-600 border-b cursor-pointer border-b-gray-300"
                @click="handleDeleteClick"
            >
                Delete {{ deleteType }}
            </button>

            <button class="w-full p-3 text-lg" @click="$emit('close')">
                Cancel
            </button>
        </div>
    </div>
</template>
