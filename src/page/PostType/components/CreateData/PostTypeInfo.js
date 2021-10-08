import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import { makeStyles } from '@material-ui/core';
import ListItemText from '@material-ui/core/ListItemText';
import AvatarGroup from '@material-ui/lab/AvatarGroup';
import AvatarCustom from 'components/AvatarCustom';
import React from 'react';
import { __ } from 'utils/i18n';


const useStyles = makeStyles(() => ({
    listInfo: {
        '& .MuiListItem-root': {
            whiteSpace: 'nowrap'
        }
    },
}));

function PostTypeInfo({ data }) {
    const classes = useStyles();

    return (
        <List component="nav" className={classes.listInfo} aria-label="secondary mailbox folders">
            <ListItem button>
                <ListItemText><strong>ID:</strong> {data.post.id} </ListItemText>
            </ListItem>
            {

                data.author ?
                    <ListItem button>
                        <ListItemText><strong>{__('Author')}:</strong>
                            <AvatarCustom
                                image={data.author.profile_picture}
                                name={data.author.first_name + ' ' + data.author.last_name}
                            />
                        </ListItemText>
                    </ListItem>
                    : null
            }

            {
                data.editor && data.editor.length ?
                    <ListItem button>
                        <ListItemText>
                            <strong>{__('Editor')}:</strong>
                            <AvatarGroup max={6}>
                                {data.editor.map((user, index) =>
                                    <AvatarCustom
                                        key={index}
                                        image={user.profile_picture}
                                        name={user.first_name + ' ' + user.last_name}
                                    />
                                )}
                            </AvatarGroup>
                        </ListItemText>
                    </ListItem>
                    : null
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
        </List>
    )
}

export default PostTypeInfo
