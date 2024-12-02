<template>
    <div class="flex items-start pt-4">
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
            <div class="px-4 py-2 mt-1 bg-gray-100 border rounded-lg shadow-sm">
                <div
                    class="prose-sm prose max-w-none"
                    v-html="comment.html"
                ></div>
                <div class="flex items-center space-x-2">
                    <LikeButton
                        :href="route('likes.store', ['comment', comment.id])"
                        :liked="false"
                        v-if="comment.can.like"
                    />
                    <LikeButton
                        :href="route('likes.destroy', ['comment', comment.id])"
                        :liked="true"
                        method="delete"
                        v-else
                    />
                    <span class="font-semibold text-gray-700"
                        >{{ comment.likes_count }} like</span
                    >
                </div>
            </div>
            <div class="flex justify-between mt-2 text-xs text-gray-500">
                <!-- User Info -->
                <div>
                    By
                    <span class="font-medium text-gray-700">
                        {{ comment.user.name }}
                    </span>
                    <span class="ml-2">
                        {{ relativeDate(comment.created_at) }}
                    </span>
                </div>

                <!-- Actions -->

                <div class="flex space-x-3">
                    <button
                        v-if="comment.can?.update"
                        type="button"
                        @click="$emit('edit', comment.id)"
                        class="text-blue-500 hover:underline"
                        aria-label="Edit Comment"
                    >
                        Edit
                    </button>
                    <button
                        v-if="comment.can?.delete"
                        type="button"
                        @click="$emit('delete', comment.id)"
                        class="text-red-500 hover:underline"
                        aria-label="Delete Comment"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { relativeDate } from "@/Utilities/date.js";
import LikeButton from "./LikeButton.vue";

const props = defineProps(["comment"]);
const emit = defineEmits(["edit", "delete"]);
</script>
