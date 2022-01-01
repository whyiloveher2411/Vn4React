import { Accordion, AccordionActions, AccordionDetails, AccordionSummary, Button, Checkbox, Divider, FormControl, FormControlLabel, FormGroup, Grid, Typography } from '@material-ui/core';
import ExpandMoreIcon from '@material-ui/icons/ExpandMore';
import { Skeleton } from '@material-ui/lab';
import React from 'react';
import { __ } from 'utils/i18n';
import { CircularCustom } from 'components';
import { useAjax } from 'utils/useAjax';
import MenuItemCustomLink from './MenuItemCustomLink';

function MenuItem({ listPostType, listMenu, setListMenu, tree, setTree }) {

    const [postType, setPostType] = React.useState({});
    const [listMenuChecked, setListMenuChecked] = React.useState({});

    React.useLayoutEffect(() => {
        if (listPostType) {

            // Object.keys(postType).filter(key => postType[key].public_view)

            let postTypeHasView = Object.keys(listPostType).filter(key => listPostType[key].public_view), postType = {
                __postType: {
                    title: __('Post Type'),
                    isTitle: true,
                }
            };

            postTypeHasView.forEach((key) => {
                postType[key] = listPostType[key];
            });

            postType['__system'] = {
                title: __('System'),
                isTitle: true,
            };

            postType['__page'] = {
                title: __('Page Static'),
            };

            postType['__customLink'] = {
                title: __('Custom Link'),
                component: MenuItemCustomLink
            };

            setPostType({ ...postType });
        }
    }, [listPostType]);

    const { ajax } = useAjax();

    const [expanded, setExpanded] = React.useState('0');

    const loadDataPostType = (type) => {
        ajax({
            url: 'menu/get-post',
            method: 'POST',
            isGetData: false,
            data: {
                object_type: type,
                type: 'getPostType'
            },
            success: (result) => {
                if (result.rows) {
                    setPostType({ ...postType, [type]: { ...postType[type], __data: result.rows } });
                }
            }
        });
    };

    const handleChange = (panel) => (event, newExpanded) => {

        let expanded = newExpanded ? panel : false;

        if (expanded && !postType[panel].__data) {
            loadDataPostType(panel);
        }

        setExpanded(newExpanded ? panel : false);
    };

    const SelectAll = (key) => () => {

        let listMenu = { ...listMenuChecked };
        if (!listMenu[key]) listMenu[key] = [];

        if (listMenu[key].length === postType[key].__data.length) {
            listMenu[key] = [];
        } else {
            postType[key].__data.forEach(item => {
                if (listMenu[key].indexOf(item.id + '') === -1) {
                    listMenu[key].push(item.id + '');
                }
            });
        }
        setListMenuChecked(listMenu);
    }

    const handleClickMenu = (key) => (e) => {

        let listMenu = { ...listMenuChecked };

        if (!listMenu[key]) listMenu[key] = [];

        if (e.target.checked) {
            listMenu[key].push(e.target.value + '');
        } else {
            const index = listMenu[key].indexOf(e.target.value + '');
            if (index > -1) {
                listMenu[key].splice(index, 1);
            }
        }

        console.log(listMenu);
        setListMenuChecked(listMenu);
    }

    const addMenuItem = (key) => () => {
        ajax({
            url: 'menu/add-menu-item',
            method: 'POST',
            isGetData: false,
            data: {
                object_type: key,
                data: listMenuChecked[key],
                type: 'addPostTypeItem'
            },
            success: (result) => {

                if (result.menus) {

                    let menuJson;

                    if (tree) {
                        menuJson = [...tree];
                    } else {
                        menuJson = [];
                    }

                    menuJson = [...menuJson, ...result.menus];
                    listMenu.list_option[listMenu.value].json = menuJson;

                    setListMenu({ ...listMenu });
                    setTree(menuJson);
                }
            }
        });
    };


    if (!listPostType) {
        return (
            <Grid
                container
                spacing={3}>
                <Grid item md={12} xs={12}>
                    {
                        [...Array(10)].map((key, index) => {
                            return <Skeleton key={index} style={{ margin: '10px 0', transform: 'scale(1, 1)' }} animation="wave" height={48} />
                        })
                    }
                </Grid>
            </Grid>
        )
    }

    return (
        <Grid
            container
            spacing={3}>
            <Grid item md={12} xs={12}>
                {
                    Object.keys(postType).map((key) => {

                        let postTypeItem = postType[key];

                        return postTypeItem.isTitle ?
                            <Typography style={{ margin: '24px 0 8px 0' }} key={key} variant='h5'>{postTypeItem.title}</Typography>
                            :
                            <Accordion key={key} expanded={expanded === key} onChange={handleChange(key)}>
                                <AccordionSummary
                                    expandIcon={<ExpandMoreIcon />}
                                    aria-controls="panel1a-content"
                                    id="panel1a-header"
                                >
                                    <Typography>{postTypeItem.title}</Typography>
                                </AccordionSummary>
                                {
                                    postTypeItem.component ?
                                        <postTypeItem.component tree={tree} setTree={setTree} listMenu={listMenu} setListMenu={setListMenu} />
                                        :
                                        <>
                                            <AccordionDetails className="custom_scroll">
                                                {
                                                    postTypeItem.__data ?
                                                        <FormControl required component="fieldset">
                                                            <FormGroup>
                                                                {
                                                                    postTypeItem.__data.map(item => (
                                                                        <FormControlLabel
                                                                            key={item.id}
                                                                            control={<Checkbox value={item.id} checked={Boolean(listMenuChecked[key] && listMenuChecked[key].indexOf(item.id + '') !== -1)} onChange={handleClickMenu(key)} color="primary" />}
                                                                            label={item.title}
                                                                        />
                                                                    ))
                                                                }

                                                            </FormGroup>
                                                        </FormControl>
                                                        :
                                                        <CircularCustom />
                                                }

                                            </AccordionDetails>
                                            <Divider />
                                            <AccordionActions style={{ justifyContent: 'space-between' }}>
                                                <FormControl required component="fieldset">
                                                    <FormGroup>
                                                        <FormControlLabel
                                                            control={<Checkbox
                                                                checked={
                                                                    Boolean(postTypeItem.__data?.length && listMenuChecked[key] && listMenuChecked[key].length === postTypeItem.__data.length)
                                                                }
                                                                color="primary"
                                                                indeterminate={
                                                                    listMenuChecked[key] && listMenuChecked[key].length > 0
                                                                    && listMenuChecked[key].length < postTypeItem.__data?.length
                                                                }
                                                                onClick={SelectAll(key)}
                                                            />}
                                                            label={''}
                                                        />
                                                    </FormGroup>
                                                </FormControl>


                                                <span>
                                                    <Button size="small" onClick={addMenuItem(key)} color="primary">
                                                        {__('Add to menu')}
                                                    </Button>
                                                </span>
                                            </AccordionActions>
                                        </>
                                }
                            </Accordion>
                    })
                }
            </Grid>
        </Grid>
    )
}

export default MenuItem
