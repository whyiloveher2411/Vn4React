import React from "react";

export default function useForm(props) {
    
    const [post, setPost] = React.useState(props);

    const onUpdateData = (value, key) => {
        setPost(prev => {
            if (value instanceof Function) {
                return { ...value(prev) };
            } else {
                if (typeof key === 'object' && key !== null) {
                    prev = {
                        ...prev,
                        ...key
                    };
                } else {
                    prev[key] = value;
                }
            }

            return { ...prev };
        });
    }

    return [
        post,
        setPost,
        onUpdateData,
    ];
}