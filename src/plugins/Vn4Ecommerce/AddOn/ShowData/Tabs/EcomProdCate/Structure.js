import { Badge, Card, CardActions, CardContent, Divider, IconButton, makeStyles, Tooltip, Typography } from '@material-ui/core';
import EditOutlinedIcon from '@material-ui/icons/EditOutlined';
import FlashOnOutlinedIcon from '@material-ui/icons/FlashOnOutlined';
import ShoppingCartOutlinedIcon from '@material-ui/icons/ShoppingCartOutlined';
import { Skeleton } from '@material-ui/lab';
import { Button, NotFound } from 'components';
import EditPostType from 'components/EditPostType';
import React from 'react';
import { useHistory } from "react-router-dom";
import SortableTree from 'react-sortable-tree';
import 'react-sortable-tree/style.css';
import { convertListToTree } from 'utils/helper';
import { useAjax } from 'utils/useAjax';
import { __, __p } from 'utils/i18n';
import { PLUGIN_NAME } from 'plugins/Vn4Ecommerce/helpers/plugin';

const useStyles = makeStyles((theme) => ({
    root: {
        flexGrow: 1,
        '& .rst__rowLandingPad': {
            opacity: 1,
            backgroundColor: theme.palette.dividerDark,
            borderRadius: 5,
            border: '1px dashed #5a9ae5 !important',
        },
        '& .rst__nodeContent': {
            right: 0
        },
        '& .rst__collapseButton, & .rst__expandButton': {
            boxShadow: 'none',
            border: '1px solid #bdbdbd'
        },
        '& .rst__lineHalfHorizontalRight::before,& .rst__lineFullVertical::after,& .rst__lineHalfVerticalTop::after,& .rst__lineHalfVerticalBottom::after,& .rst__lineChildren::after': {
            backgroundColor: theme.palette.dividerDark,
        },
        '& .rst__row': {
            overflow: 'hidden',
            borderRadius: 5,
            boxShadow: '1px 1px 5px rgba(0, 0, 0, 0.2)',
            maxWidth: 600,
        },
        '& .rst__rowContents': {
            borderRadius: '0 5px 5px 0',
            padding: 0,
            backgroundColor: theme.palette.background.default,
            borderColor: theme.palette.dividerDark,
        },
        '& .rst__moveHandle,& .rst__loadingHandle': {
            background: theme.palette.background.selected + " url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RTdBRUU5M0M3Njg3MTFFQkE5M0NCOUZFMTM3NzdBOEEiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RTdBRUU5M0Q3Njg3MTFFQkE5M0NCOUZFMTM3NzdBOEEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpFN0FFRTkzQTc2ODcxMUVCQTkzQ0I5RkUxMzc3N0E4QSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpFN0FFRTkzQjc2ODcxMUVCQTkzQ0I5RkUxMzc3N0E4QSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PmMpG7UAAACmSURBVHja7NgxDoAgDAVQazwbd4bLYZxMcMC5fV1I3PosTfgx5zwq13kULwAAAAAAAAAAAABV61o/jDGeI+sDIVpr2wnI/DqargAAAAAAbAAicb+f3mLNBCMi9R9f+3UFAAAAAACAPOCt3nvqPODPBMgD7AAAAADIA+QB8gA7AAAAAAAAyAPkAfIAOwAAAADygCp5gAkAAAAAAAAAAAAAAKBE3QIMADtvIs1XDohhAAAAAElFTkSuQmCC') no-repeat center",
            borderRadius: '5px 0 0 5px',
            backgroundSize: '20px',
            borderColor: theme.palette.dividerDark,
        },
        '& .rst__rowLabel,& .rst__rowTitle,& .rst__rowWrapper .MuiTypography-root': {
            display: 'flex',
            flexDirection: 'column',
            justifyContent: 'center',
            width: '100%',
            height: '100%',
        },
        '& .rst__rowWrapper .MuiTypography-root small': {
            lineHeight: '11px', fontWeight: 'normal', color: theme.palette.text.secondary, fontSize: 11
        },
        '& .rst__rowWrapper .MuiTypography-root': {
            paddingLeft: 10,
            cursor: 'pointer'
        },
        '& .icon-edit': {
            color: '#8b8b8b',
            opacity: 0.5,
        },
        '& .icon-edit:hover': {
            color: theme.palette.primary.main,
            opacity: 1,
        },
        '& .rst__toolbarButton': {
        }
    },
    fieldLocation: {
        '& .MuiFormControlLabel-root': {
            marginRight: 8
        }
    },
}));



function Structure(props) {

    const classes = useStyles();

    const useAjax1 = useAjax();

    const history = useHistory();

    const [posts, setPosts] = React.useState(false);
    const [openDrawer, setOpenDrawer] = React.useState(false);

    const saveStruct = () => {
        useAjax1.ajax({
            url: 'plugin/vn4-ecommerce/category/struct-save',
            data: {
                posts: posts
            },
            success: (result) => {
                if (result.posts) {
                    setPosts(convertListToTree(result.posts));
                }
            },
        });
    };

    React.useEffect(() => {
        useAjax1.ajax({
            url: 'plugin/vn4-ecommerce/category/struct-get',
            success: (result) => {
                if (result.posts) {
                    setPosts(convertListToTree(result.posts));
                }
            },
        });
    }, []);

    const editPostInTree = (post, posts) => {

        posts.forEach((item, key) => {
            if (item.id === post.id) {
                posts[key] = { ...item, ...post };
            }

            if (item.children) {
                editPostInTree(post, item.children);
            }
        });
    }

    const editPost = (post) => {
        editPostInTree(post, posts);
        setPosts([...posts]);
    }

    if (posts) {
        return (
            <>
                <Card className={classes.root} >
                    <CardContent>
                        {
                            Boolean(posts.length > 0) ?
                                <SortableTree
                                    isVirtualized={false}
                                    treeData={posts}
                                    rowHeight={70}
                                    onChange={(treeData => { setPosts(treeData) })}
                                    generateNodeProps={(rowInfo) => ({
                                        title: (<Typography onClick={() => { }} variant='h6'>{rowInfo.node.title}<small>{rowInfo.node.description}</small></Typography>),
                                        buttons: [
                                            rowInfo.node.productCount ?
                                                <Tooltip title={__p('Product count', PLUGIN_NAME)}>
                                                    <IconButton>
                                                        <Badge badgeContent={rowInfo.node.productCount} max={1000000} color="secondary">
                                                            <ShoppingCartOutlinedIcon />
                                                        </Badge>
                                                    </IconButton>
                                                </Tooltip> : null,
                                            <Tooltip title={__p('Quick edit', PLUGIN_NAME)}>
                                                <IconButton
                                                    onClick={() => setOpenDrawer(rowInfo.node.id)}
                                                    className="icon-edit"
                                                    aria-label="Edit" component="span">
                                                    <FlashOnOutlinedIcon fontSize="small" />
                                                </IconButton>
                                            </Tooltip>,
                                            <Tooltip title={__('Edit')}>
                                                <IconButton
                                                    onClick={() => history.push('/post-type/ecom_prod_cate/edit?post_id=' + rowInfo.node.id)}
                                                    className="icon-edit"
                                                    aria-label="Edit" component="span">
                                                    <EditOutlinedIcon fontSize="small" />
                                                </IconButton>
                                            </Tooltip>,

                                        ],
                                    })}
                                />
                                :
                                <NotFound />
                        }

                    </CardContent>
                    {
                        Boolean(posts.length > 0) &&
                        <>
                            <Divider />
                            <CardActions style={{ display: 'flex', justifyContent: 'flex-end' }}>
                                <Button onClick={saveStruct} color="success" variant="contained">{__('Save Changes')}</Button>
                            </CardActions>
                        </>
                    }
                </Card>

                <EditPostType
                    open={openDrawer !== false}
                    onClose={() => setOpenDrawer(false)}
                    id={openDrawer}
                    postType={'ecom_prod_cate'}
                    onEdit={editPost}
                />

            </>
        )
    }

    return (
        <Card className={classes.root} >
            <CardContent>
                {
                    [1, 2, 3, 4, 5, 6].map(key => (
                        <Skeleton key={key} style={{ marginTop: 20 }} variant="rect" width={'100%'} height={48} />
                    ))
                }
            </CardContent>
            <Divider />
            <CardActions style={{ display: 'flex', justifyContent: 'flex-end' }}>
                <Skeleton variant="rect" width={'100%'} height={36} />
            </CardActions>
        </Card>
    );

}

export default Structure
