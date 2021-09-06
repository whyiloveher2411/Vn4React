import React from 'react'
import DrawerCustom from './DrawerCustom';
import { useAjax } from 'utils/useAjax';
import DrawerEditPost from './FieldForm/relationship_onetomany_show/DrawerEditPost';
import { Box } from '@material-ui/core';

function EditPostType({ open, onClose, id, postType, onEdit }) {

    const [data, setData] = React.useState(false);
    const useAjax1 = useAjax({ loadingType: 'custom' });

    React.useEffect(() => {

        if (open) {
            useAjax1.ajax({
                url: 'post-type/detail/' + postType + '/' + id,
                data: {
                    id: id
                },
                success: (result) => {
                    if (result.post) {
                        result.type = postType;
                        result.updatePost = new Date();
                        setData({ ...result });
                    } else {
                        onClose();
                    }
                }
            });
        }

    }, [open]);

    const handleSubmit = () => {

        if (!useAjax1.open) {
            useAjax1.ajax({
                url: 'post-type/post/' + postType,
                method: 'POST',
                data: { ...data.post, _action: 'EDIT' },
                isGetData: false,
                success: (result) => {
                    if (result.post?.id) {
                        if (onEdit) {
                            onEdit(result.post);
                        }
                        onClose();
                        setData(false);
                    }
                }
            });
        }

    };

    return (
        <DrawerEditPost
            open={open}
            onClose={() => { setData(false); onClose(); }}
            data={data}
            handleSubmit={handleSubmit}
            showLoadingButton={useAjax1.open}
        >
            {
                useAjax1.open &&
                <Box style={{ height: 300 }} width={1} display="flex" justifyContent="center" alignItems="center">
                    {useAjax1.Loading}
                </Box>
            }
        </DrawerEditPost>
    )
}

export default EditPostType
