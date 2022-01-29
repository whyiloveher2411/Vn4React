import { Grid, IconButton, makeStyles, Tooltip } from '@material-ui/core';
import RedirectWithMessage from 'components/RedirectWithMessage';
import ArrowBackOutlined from '@material-ui/icons/ArrowBackOutlined';
import { PageHeaderSticky } from 'components/Page';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import { usePermission } from 'utils/user';
import EditMenu from './components/Edit/EditMenu';
import MenuItem from './components/Edit/MenuItem';
import Header from './components/Header';
import { __ } from 'utils/i18n';
import { useHistory, useRouteMatch } from 'react-router-dom';

const useStyles = makeStyles((theme) => ({
    root: {
        '& .btn-save-changes': {
            color: theme.palette.buttonSave.contrastText,
            backgroundColor: theme.palette.buttonSave.main,
            '&:hover': {
                backgroundColor: theme.palette.buttonSave.dark,
            },
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


function Edit() {

    const classes = useStyles();

    const { ajax, Loading } = useAjax();

    const [tree, setTree] = React.useState([]);

    const history = useHistory();

    const match = useRouteMatch();

    const { subtab2 } = match.params;

    const permission = usePermission('menu_management').menu_management;

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
            updateData({
                id: subtab2
            }, 'appearance-menu/list-struct-edit', false);
        }
    }, [subtab2]);

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
        history.push('/appearance/menu/edit/' + value);

        // console.log(value);
        // let listOption = {
        //     ...listMenu.list_option,
        //     [listMenu.value]: {
        //         ...listMenu.list_option[listMenu.value],
        //         json: [...tree],
        //         title: listMenu.title
        //     }
        // };

        // if (listOption[value]) {
        //     setListMenu(
        //         {
        //             list_option: listOption,
        //             title: listOption[value].title,
        //             value: value
        //         }
        //     );
        //     setTree(listMenu.list_option[value].json);
        // }

    };

    const saveChanges = () => {

        console.log(listMenu.list_option);

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
        <PageHeaderSticky
            title={__('Menu')}
            header={<Header back="/appearance/menu/list" />}
        >
            <Grid container
                spacing={3}>
                <Grid item md={4} xs={12} className={classes.colleft}>
                    <MenuItem listMenu={listMenu} setListMenu={setListMenu} setTree={setTree} tree={tree} listPostType={listPostType} />
                </Grid>
                <Grid item md={8} xs={12}>
                    <EditMenu location={location} setLocation={setLocation} changeMenuEdit={changeMenuEdit} tree={tree} listMenu={listMenu} listPostType={listPostType} setListMenu={setListMenu} setTree={setTree} saveChanges={saveChanges} deleteMenu={deleteMenu} />
                </Grid>
            </Grid>
        </PageHeaderSticky>
    )
}

export default Edit
