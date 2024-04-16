import {
    ApertureIcon,
    CopyIcon,
    LayoutDashboardIcon, LoginIcon, MoodHappyIcon, TypographyIcon, UserPlusIcon
} from 'vue-tabler-icons';

export interface menu {
    header?: string;
    title?: string;
    icon?: any;
    to?: string;
    chip?: string;
    chipColor?: string;
    chipVariant?: string;
    chipIcon?: string;
    children?: menu[];
    disabled?: boolean;
    type?: string;
    subCaption?: string;
}

const sidebarItem: menu[] = [
    { header: 'utilities' },
    {
        title: 'Dashboard',
        icon: LayoutDashboardIcon,
        to: '/'
    },
    {
        title: 'Fruit Category',
        icon: TypographyIcon,
        to: '/category'
    },
    {
        title: 'Fruit Item',
        icon: CopyIcon,
        to: '/product'
    },
    {
        title: 'Invoice',
        icon: ApertureIcon,
        to: '/invoice'
    },
];

export default sidebarItem;
