import { IconButton, makeStyles, Tooltip } from '@material-ui/core';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import DeleteRoundedIcon from '@material-ui/icons/DeleteRounded';
import EditOutlinedIcon from '@material-ui/icons/EditOutlined';
import InfoOutlinedIcon from '@material-ui/icons/InfoOutlined';
import LinkRoundedIcon from '@material-ui/icons/LinkRounded';
import RestoreRoundedIcon from '@material-ui/icons/RestoreRounded';
import { CustomTooltip, Hook } from 'components';
import React from 'react';
import { __ } from 'utils/i18n';
import { usePermission } from 'utils/user';
import PostTypeInfo from './PostTypeInfo';

const useStyles = makeStyles((theme) => ({
    actionPost: {
        position: 'absolute',
        top: '50%',
        right: '0',
        minWidth: '100%',
        backgroundColor: theme.palette.background.default,
        transform: 'translateY(-50%)',
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

    const permission = usePermission(
        post.type + '_edit',
        post.type + '_delete',
        post.type + '_restore',
        post.type + '_trash'
    )
    return (
        <div className={classes.actionPost + ' actionPost'}>

            {
                fromLayout !== 'list' && permission[post.type + '_edit'] &&
                <Tooltip title={__('Edit')} aria-label="edit">
                    <IconButton
                        onClick={(e) => { e.stopPropagation(); history.push(`/post-type/${post.type}/edit?post_id=${post.id}`); }}
                        aria-label={__('Edit')}
                    >
                        <EditOutlinedIcon />
                    </IconButton>
                </Tooltip>
            }
            {
                post.status === 'trash' ?
                    <>
                        {
                            permission[post.type + '_delete'] &&
                            <Tooltip title={__('Permanently Deleted')} aria-label="permanently-deleted">
                                <IconButton
                                    className={classes.delete}
                                    onClick={(e) => { e.stopPropagation(); setConfirmDelete(post.id) }}
                                    aria-label={__('Permanently Deleted')}
                                >
                                    <ClearRoundedIcon />
                                </IconButton>
                            </Tooltip>
                        }
                        {
                            permission[post.type + '_restore'] &&
                            <Tooltip title={__('Restore')} aria-label="restore">
                                <IconButton
                                    className={classes.restore}
                                    onClick={(e) => { e.stopPropagation(); acctionPost({ restore: [post.id] }); }}
                                    aria-label={__('Restore')}
                                >
                                    <RestoreRoundedIcon />
                                </IconButton>
                            </Tooltip>
                        }
                    </>
                    :
                    <>

                        <CustomTooltip style={{ color: '#337ab7' }} title={<PostTypeInfo data={{ post: post }} />}   >
                            <IconButton>
                                <InfoOutlinedIcon />
                            </IconButton>
                        </CustomTooltip>
                        {
                            Boolean(post._permalink) &&
                            <Tooltip title={__('View post')} aria-label="view-post">
                                <IconButton style={{ color: '#337ab7' }} onClick={(e) => { e.stopPropagation(); }} href={post._permalink} target="_blank" >
                                    <LinkRoundedIcon />
                                </IconButton>
                            </Tooltip>
                        }
                        {
                            permission[post.type + '_trash'] &&
                            <Tooltip title={__('Trash')} aria-label="Trash">
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
