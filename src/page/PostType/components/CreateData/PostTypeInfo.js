import { List, ListItem, ListItemText, makeStyles, Chip } from '@material-ui/core'
import AvatarGroup from '@material-ui/lab/AvatarGroup';
import { AvatarCustom } from 'components';
import React from 'react'


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
                        <ListItemText><strong>Author:</strong>
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
                            <strong>Editor:</strong>
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
                <ListItemText><strong>Created At:</strong> {data.post.created_at} </ListItemText>
            </ListItem>
            <ListItem button>
                <ListItemText><strong>Last Updated:</strong> {data.post.updated_at} </ListItemText>
            </ListItem>
            <ListItem button>
                <ListItemText><strong>Update:</strong> {data.post.update_count} times</ListItemText>
            </ListItem>
        </List>
    )
}

export default PostTypeInfo
