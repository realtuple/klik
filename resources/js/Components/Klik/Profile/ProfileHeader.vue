<script lang="ts" setup>
    import defaultPfp from '@img/ui/defaultPfp.svg?url';
    import { usePage } from '@inertiajs/vue3';
    import YourProfileBar from './HeaderButtonBar/YourProfileBar.vue';
    import { ShowProfileProps } from '@/Types/Inertia';
    import UnknownProfileBar from './HeaderButtonBar/UnknownProfileBar.vue';

    const currentProfile = usePage<ShowProfileProps>().props.current_profile;
    const shownProfile = usePage<ShowProfileProps>().props.shown_profile;

    function getPfp() {
        const pfpId = shownProfile.pfp;
        if (pfpId === null) return defaultPfp;
        return `/storage/${pfpId}`;
    }
</script>

<template>
    <div class="flex justify-center">
        <div class="flex flex-col justify-center">
            <div class="flex flex-row w-175 pb-3">
                <img :src="getPfp()" class="h-32 w-32 object-cover" alt="Profile Picture" />
                <div class="pl-5 flex flex-col justify-center">
                    <h1 class="font-semibold text-3xl">
                        {{ shownProfile.username }}
                    </h1>
                    <h1 class="text-xl">{{ shownProfile.display_name }}</h1>
                    <h1>{{ shownProfile.bio }}</h1>
                </div>
            </div>
            <div class="flex w-175">
                <YourProfileBar v-if="currentProfile.id == shownProfile.id" />
                <UnknownProfileBar v-else />
            </div>
        </div>
    </div>
</template>
