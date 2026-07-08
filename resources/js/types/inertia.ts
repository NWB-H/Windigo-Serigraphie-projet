import { PageProps } from '@inertiajs/core';
import { User } from '@/types/index';

interface AuthenticatedUserPage extends PageProps {
    auth: {
        user: User;
    };
}

export default AuthenticatedUserPage;
