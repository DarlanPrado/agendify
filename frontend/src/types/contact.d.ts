interface Contact {
    id: number;
    name: string;
    email?: string | undefined;
    address?: string | undefined;
    telephone?: string | undefined;
    created_at?: string | undefined;
    updated_at?: string | undefined;
}

export default Contact;