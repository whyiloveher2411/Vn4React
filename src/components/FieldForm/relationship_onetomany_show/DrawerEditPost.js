import { IconButton, Typography } from '@material-ui/core';
import CloseIcon from '@material-ui/icons/Close';
import { DrawerCustom } from 'components';
import Form from 'page/PostType/components/CreateData/Form';
import Header from 'page/PostType/components/CreateData/Header';
import React from 'react';
import { useSelector } from 'react-redux';

function DrawerEditPost({ data, open, onClose, handleSubmit, showLoadingButton, children }) {

    const theme = useSelector(state => state.theme);

    const onReview = (value) => {
        data.post = { ...data.post, ...value };
    };

    return (
        <DrawerCustom
            restDialogContent={
                {
                    style: {
                        background: theme.palette.body.background,
                        paddingTop: 0,
                    }
                }
            }
            {...data?.config?.dialogContent}
            title={
                <Typography variant="h4" style={{ display: 'flex', alignItems: 'center', color: 'white' }}>
                    <IconButton style={{ margin: '-8px 4px -8px -12px' }} edge="start" color="inherit" onClick={onClose} aria-label="close">
                        <CloseIcon />
                    </IconButton>  Edit {data?.config?.label?.singularName ?? ""}
                </Typography>
            }
            open={open}
            onClose={onClose}
        >
            <Header
                postType={data.type}
                data={data}
                title={'edit ' + (data?.config?.label?.singularName ?? '')}
                handleSubmit={handleSubmit}
                showLoadingButton={showLoadingButton}
                hiddenAddButton={true}
                onReview={onReview}
            />
            <br />
            {data &&
                <Form
                    data={data}
                    postType={data.type}
                    onReview={onReview}
                />
            }
            {children}
        </DrawerCustom>
    )
}

export default DrawerEditPost
