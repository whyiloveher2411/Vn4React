import { IconButton, Typography } from '@material-ui/core';
import CloseIcon from '@material-ui/icons/Close';
import { DrawerCustom } from 'components';
import Form from 'page/PostType/components/CreateData/Form';
import Header from 'page/PostType/components/CreateData/Header';
import React from 'react';
import { useSelector } from 'react-redux';

function DrawerEditPost({ data, setData, open, onClose, handleSubmit, showLoadingButton, children }) {

    const theme = useSelector(state => state.theme);

    const onUpdateData = (value, key) => {
        setData(prev => {
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
            title={"Edit "+ data?.config?.title ?? "Post"}
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
            />
            <br />
            {data &&
                <Form
                    data={data}
                    postType={data.type}
                    onUpdateData={onUpdateData}
                />
            }
            {children}
        </DrawerCustom>
    )
}

export default DrawerEditPost
