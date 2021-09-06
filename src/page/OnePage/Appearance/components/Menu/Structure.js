import { Box, Grid, makeStyles } from '@material-ui/core';
import { TabsCustom } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import { checkPermission } from 'utils/user';
import EditMenu from './EditMenu';
import Header from './Header';
import ListNewMenu from './ListNewMenu';
import MenuItem from './MenuItem';


const useStyles = makeStyles((theme) => ({
    root: {
        '& .btn-save-changes': {
            color: theme.palette.buttonSave.contrastText,
            backgroundColor: theme.palette.buttonSave.main,
            '&:hover': {
                backgroundColor: theme.palette.buttonSave.dark,
            }
        },
        '& .color-remove:hover': {
            color: theme.palette.secondary.dark,
        }
    },
    colleft: {
        '& .MuiFormControlLabel-label': {
            wordBreak: 'break-word',
        },
        '& .custom_scroll': {
            position: 'relative', flexDirection: 'column', height: 160, maxHeight: 160, overflowY: 'auto', overflowX: 'hidden'
        },
        '& .custom_scroll .MuiFormControlLabel-root': {
            marginBottom: 8
        },
        '& .MuiAccordionActions-root': {
            padding: '8px 16px',
        }
    },
}));


function Structure() {

    const classes = useStyles();

    const { ajax, Loading } = useAjax();

    const [tree, setTree] = React.useState([]);
    const permission = checkPermission('menu_management');

    const [listMenu, setListMenu] = React.useState({
        list_option: false,
        value: 0,
        title: ''
    });

    const [location, setLocation] = React.useState(false);

    const [listPostType, setListPostType] = React.useState(false);

    const updateData = (data, url = 'appearance-menu', loading = true, callback = null) => {

        ajax({
            url: url,
            method: 'POST',
            data: data,
            loading: loading,
            success: (result) => {
                if (result.menus) {
                    let listMenu = {
                        list_option: {},
                        value: 0,
                    };

                    result.menus.forEach((item, index) => {

                        try {
                            item.json = JSON.parse(item.json);
                        } catch (error) {

                        }
                        if (!item.json || typeof item.json !== 'object') item.json = [];

                        expandedItemMenu(item.json);

                        if (index === 0) {
                            listMenu.value = item.id;
                            listMenu.title = item.title;
                            setTree(item.json);
                        }

                        listMenu.list_option[item.id] = { ...item };

                    });
                    setListMenu(listMenu);
                    if (!listPostType) {
                        setListPostType(result.post_type);
                    }
                    if (result.location) {
                        setLocation(result.location);
                    }
                }
                // }

                if (callback) {
                    callback(result, listMenu, setListMenu);
                }
            }
        });
    };

    React.useEffect(() => {
        if (permission) {
            updateData({}, 'appearance-menu/list-struct-edit', false);
        }
    }, []);

    const expandedItemMenu = (menuItem) => {
        if (menuItem) {
            menuItem.forEach(item => {

                if (item.expanded === undefined) {
                    item.expanded = true;
                }

                if (item.children) {
                    expandedItemMenu(item.children);
                }
            });
        }
    };

    const changeMenuEdit = (value) => {

        let listOption = {
            ...listMenu.list_option,
            [listMenu.value]: {
                ...listMenu.list_option[listMenu.value],
                json: [...tree],
                title: listMenu.title
            }
        };

        if (listOption[value]) {
            setListMenu(
                {
                    list_option: listOption,
                    title: listOption[value].title,
                    value: value
                }
            );
            setTree(listMenu.list_option[value].json);
        }

    };

    const saveChanges = () => {

        let listOption = {
            ...listMenu.list_option,
            [listMenu.value]: {
                ...listMenu.list_option[listMenu.value],
                json: [...tree],
                title: listMenu.title
            }
        };

        updateData({
            menuItem: listOption,
            location: location,
            update: true,
        }, 'appearance-menu/update');
    };

    const deleteMenu = () => {
        updateData({
            id: listMenu.value,
        }, 'appearance-menu/delete');
    }

    if (!permission) {
        return <RedirectWithMessage />
    }

    return (
        <Grid container
            spacing={3}>
            <Grid item md={12} xs={12}>
                <Header listMenu={listMenu} changeMenuEdit={changeMenuEdit} listPostType={listPostType} />
            </Grid>
            <Grid item md={4} xs={12} className={classes.colleft}>
                <MenuItem listMenu={listMenu} setListMenu={setListMenu} setTree={setTree} tree={tree} listPostType={listPostType} />
            </Grid>
            <Grid item md={8} xs={12}>
                <EditMenu location={location} setLocation={setLocation} changeMenuEdit={changeMenuEdit} tree={tree} listMenu={listMenu} listPostType={listPostType} setListMenu={setListMenu} setTree={setTree} saveChanges={saveChanges} deleteMenu={deleteMenu} />
            </Grid>
        </Grid>
    )
}

export default Structure
