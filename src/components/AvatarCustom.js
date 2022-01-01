import { makeStyles } from '@material-ui/core';
import Avatar from '@material-ui/core/Avatar';
import React from 'react';

const useStyles = makeStyles(theme => ({
    image: {
        color: theme.palette.text.secondary + ' !important',
    },
    noImage: {
        width: 40,
        height: 40,
        maxWidth: '100%',
        maxHeight: '100%',
        fill: theme.palette.text.secondary + ' !important',
        backgroundColor: 'unset !important',
    },
}));

function AvatarCustom({ image = false, src = false, className, name = '', ...rest }) {

    const [imageState, setImage] = React.useState(false);
    const [nameState, setName] = React.useState(false);
    // const color = React.useState(randomColor());

    const classes = useStyles();

    React.useEffect(() => {

        let avatarUrl = src;

        try {
            if (image) {

                if (Array.isArray(image) && image[0]) {
                    image = image[0];
                }

                if (typeof image === "string") {
                    image = JSON.parse(image);
                }

                avatarUrl =
                    image.type_link === "local"
                        ? process.env.REACT_APP_BASE_URL + image.link
                        : image.link;

            }
        } catch (error) {
            avatarUrl = false;
        }

        if (!avatarUrl) avatarUrl = false;

        const fullName = name.split(' ');
        const nameInitials = fullName.pop().charAt(0).toUpperCase();

        setImage(avatarUrl);
        setName(nameInitials);

    }, [image, name]);

    // if (imageState === false) {
    //     return <></>;
    // }

    if (imageState) {

        return (
            <Avatar
                alt={name}
                src={imageState}
                className={className + ' ' + classes.image}
                {...rest}
                style={{
                    backgroundImage: "url('/admin/fileExtension/trans.jpg')",
                    // backgroundColor: color[0],
                    ...rest.style,
                }}
            >
                {nameState}
            </Avatar>
        )
    }

    return <svg
        viewBox="0 0 20 20"
        alt={name}
        {...rest}
        className={classes.noImage + ' noImage ' + className + ' ' + classes.image}
    >
        <path d="M2.5 1A1.5 1.5 0 0 0 1 2.5v15A1.5 1.5 0 0 0 2.5 19h15a1.5 1.5 0 0 0 1.5-1.5v-15A1.5 1.5 0 0 0 17.5 1h-15zm5 3.5c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zM16.499 17H3.497c-.41 0-.64-.46-.4-.79l3.553-4.051c.19-.21.52-.21.72-.01L9 14l3.06-4.781a.5.5 0 0 1 .84.02l4.039 7.011c.18.34-.06.75-.44.75z"></path>
    </svg>
}

export default AvatarCustom
