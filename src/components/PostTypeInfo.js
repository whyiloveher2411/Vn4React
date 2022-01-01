import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import { makeStyles } from '@material-ui/core';
import ListItemText from '@material-ui/core/ListItemText';
import AvatarGroup from '@material-ui/lab/AvatarGroup';
import AvatarCustom from './AvatarCustom';
import React from 'react';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import { Skeleton } from '@material-ui/lab';


const useStyles = makeStyles(() => ({
    listInfo: {
        '& .MuiListItem-root': {
            whiteSpace: 'nowrap'
        }
    },
}));

function PostTypeInfo({ data }) {
    const classes = useStyles();

    const [info, setInfo] = React.useState(false);

    const { ajax, Loading, open } = useAjax();

    React.useEffect(() => {

        if (data.post.__author) {
            setInfo(data.post.__author);
        } else {
            if (data.author || data.editor) {
                let infoTemp = {};

                if (data.author) {
                    infoTemp.author = data.author;
                }

                if (data.editor && data.editor.length) {
                    infoTemp.editor = data.editor;
                }

                setInfo(infoTemp);
            } else {
                if (!data.post.__author) {
                    ajax({
                        url: 'post-type/get-author/' + data.post.id,
                        method: 'POST',
                        data: {
                            postID: data.post.id,
                            postType: data.post.type,
                        },
                        success: (result) => {
                            if (result.success) {
                                setInfo(prev => ({ ...prev, ...result }));
                                data.post.__author = result;
                            }
                        }
                    });
                }
            }
        }
    }, []);

    return (
        <List component="nav" className={classes.listInfo} aria-label="secondary mailbox folders">
            {
                open ?

                    <div style={{ width: 280, maxWidth: '100%' }}>
                        <Skeleton variant='rect' height={36} style={{ marginBottom: 8 }} />
                        <Skeleton variant='rect' height={20} style={{ marginBottom: 4 }} />
                        <Skeleton variant='rect' height={54} style={{ marginBottom: 8 }} />
                        <Skeleton variant='rect' height={20} style={{ marginBottom: 4 }} />
                        <Skeleton variant='rect' height={54} style={{ marginBottom: 8 }} />
                        <Skeleton variant='rect' height={36} style={{ marginBottom: 8 }} />
                        <Skeleton variant='rect' height={36} style={{ marginBottom: 8 }} />
                        <Skeleton variant='rect' height={36} style={{ marginBottom: 8 }} />
                    </div>
                    :
                    <>
                        <ListItem button>
                            <ListItemText><strong>ID:</strong> {data.post.id} </ListItemText>
                        </ListItem>
                        {Boolean(info.author) &&
                            <ListItem button>
                                <ListItemText><strong>{__('Author')}:</strong>
                                    <AvatarCustom
                                        image={info.author.profile_picture}
                                        name={info.author.first_name + ' ' + info.author.last_name}
                                    />
                                </ListItemText>
                            </ListItem>
                        }
                        {
                            Boolean(info.editor) &&
                            <ListItem button>
                                <ListItemText>
                                    <strong>{__('Editor')}:</strong>
                                    <AvatarGroup max={6}>
                                        {info.editor.map((user, index) =>
                                            <AvatarCustom
                                                key={index}
                                                image={user.profile_picture}
                                                name={user.first_name + ' ' + user.last_name}
                                            />
                                        )}
                                    </AvatarGroup>
                                </ListItemText>
                            </ListItem>
                        }
                        <ListItem button>
                            <ListItemText><strong>{__('Created At')}:</strong> {data.post.created_at} </ListItemText>
                        </ListItem>
                        <ListItem button>
                            <ListItemText><strong>{__('Last Updated')}:</strong> {data.post.updated_at} </ListItemText>
                        </ListItem>
                        <ListItem button>
                            <ListItemText><strong>{__('Update')}:</strong> {data.post.update_count} {__('times')}</ListItemText>
                        </ListItem>
                    </>
            }
        </List>
    )
}

export default PostTypeInfo
