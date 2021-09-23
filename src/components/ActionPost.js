import React from 'react';
import { IconButton, makeStyles, Tooltip } from '@material-ui/core';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import DeleteRoundedIcon from '@material-ui/icons/DeleteRounded';
import LinkRoundedIcon from '@material-ui/icons/LinkRounded';
import RestoreRoundedIcon from '@material-ui/icons/RestoreRounded';
import { Hook } from 'components';
import EditOutlinedIcon from '@material-ui/icons/EditOutlined';
import { checkPermission } from 'utils/user';

const useStyles = makeStyles(() => ({
    actionPost: {
        opacity: 0,
        display: 'flex',
        justifyContent: 'flex-end',
        '&>*': {
            display: 'inline-block',
            minWidth: 'auto',
            '&:last-child': {
                border: 'none',
            }
        },
    },
    trash: {
        color: '#a00'
    },
    restore: {
        color: '#43a047'
    },
    delete: {
        color: 'red',
    },
}))

function ActionPost({ post, setConfirmDelete, acctionPost, postType, fromLayout, history }) {

    const classes = useStyles();

    return (
        <div className={classes.actionPost + ' actionPost'}>

            {
                fromLayout !== 'list' && checkPermission(post.type + '_edit') &&
                <Tooltip title="Edit" aria-label="edit">
                    <IconButton
                        onClick={(e) => { e.stopPropagation(); history.push(`/post-type/${post.type}/edit?post_id=${post.id}`); }}
                        aria-label="Edit"
                    >
                        <EditOutlinedIcon />
                    </IconButton>
                </Tooltip>
            }
            {
                post.status === 'trash' ?
                    <>
                        {
                            checkPermission(post.type + '_delete') &&
                            <Tooltip title="Permanently Deleted" aria-label="permanently-deleted">
                                <IconButton
                                    className={classes.delete}
                                    onClick={(e) => { e.stopPropagation(); setConfirmDelete(post.id) }}
                                    aria-label="Permanently Deleted"
                                >
                                    <ClearRoundedIcon />
                                </IconButton>
                            </Tooltip>
                        }
                        {
                            checkPermission(post.type + '_restore') &&
                            <Tooltip title="Restore" aria-label="restore">
                                <IconButton
                                    className={classes.restore}
                                    onClick={(e) => { e.stopPropagation(); acctionPost({ restore: [post.id] }); }}
                                    aria-label="Restore"
                                >
                                    <RestoreRoundedIcon />
                                </IconButton>
                            </Tooltip>
                        }
                    </>
                    :
                    <>
                        {
                            Boolean(post._permalink) &&
                            <Tooltip title="View post" aria-label="view-post">
                                <IconButton style={{ color: '#337ab7' }} onClick={(e) => { e.stopPropagation(); }} href={post._permalink} target="_blank" >
                                    <LinkRoundedIcon />
                                </IconButton>
                            </Tooltip>
                        }
                        {
                            checkPermission(post.type + '_trash') &&
                            <Tooltip title="Trash" aria-label="Trash">
                                <IconButton className={classes.trash} onClick={(e) => { e.stopPropagation(); acctionPost({ trash: [post.id] }); }} aria-label="Trash">
                                    <DeleteRoundedIcon />
                                </IconButton>
                            </Tooltip>
                        }
                    </>
            }
            <Hook hook="PostType/Action" screen="list" post={post} postType={postType} />
        </div>
    )
}

export default ActionPost
