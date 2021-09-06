import { Avatar } from '@material-ui/core';
import React from 'react';
import { randomColor } from 'utils/helper';

function AvatarCustom({ image, name, ...rest }) {

    const [imageState, setImage] = React.useState(false);
    const [nameState, setName] = React.useState(false);
    const color = React.useState(randomColor());

    React.useEffect(() => {

        let avatarUrl = '';

        try {
            if (image) {
                if (typeof image === "object") {
                    avatarUrl =
                        image.type_link === "local"
                            ? process.env.REACT_APP_BASE_URL + image.link
                            : image.link;
                } else {
                    let temp = JSON.parse(image);
                    avatarUrl =
                        temp.type_link === "local"
                            ? process.env.REACT_APP_BASE_URL + temp.link
                            : temp.link;
                }
            }
        } catch (error) {
            avatarUrl = '';
        }

        if (!avatarUrl) avatarUrl = '';

        const fullName = name.split(' ');
        const nameInitials = fullName.pop().charAt(0).toUpperCase();

        setImage(avatarUrl);
        setName(nameInitials);

    }, [image, name]);

    if (imageState === false) {
        return <></>;
    }

    return (
        <Avatar
            alt={name}
            src={imageState}
            {...rest}
            style={{
                ...rest.style,
                backgroundColor: color[0]
            }}
        >
            {nameState}
        </Avatar>
    )
}

export default AvatarCustom
