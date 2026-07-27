import { User } from '@/types/index';
import { PageProps } from '@inertiajs/core';

interface AuthenticatedUserPage extends PageProps {
    auth: {
        user: User;
    };
}

export default AuthenticatedUserPage;
