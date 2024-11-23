<template>
    <div class="items-start pt-4 sm:flex">
        <!-- Avatar -->
        <div class="flex-shrink-0 mb-4 sm:mb-0 sm:mr-4">
            <img
                :src="comment.user.profile_photo_url"
                alt="Avatar"
                class="w-12 h-12 rounded-full shadow-md"
            />
        </div>

        <!-- Comment Content -->
        <div class="flex-1">
            <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                <p class="text-sm text-gray-800">{{ comment.content }}</p>
            </div>
            <div class="mt-2 text-xs text-gray-500">
                <span
                    >By
                    <span class="font-medium text-gray-700">{{
                        comment.user.name
                    }}</span></span
                >
                <span class="ml-2">{{ relativeDate(comment.created_at) }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { relativeDate } from "@/Utilities/date.js";

defineProps(["comment"]);
</script>
