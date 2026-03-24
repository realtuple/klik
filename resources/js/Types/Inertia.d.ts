import { Profile } from '@/Types/Models';
import { PageProps as InertiaPageProps } from '@inertiajs/core';

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps {
        current_profile: Profile;
    }
}

type DefineProps<T> = T & InertiaPageProps;

type ShowProfileProps = DefineProps<{
    shown_profile: Profile;
}>;

export { ShowProfileProps };
