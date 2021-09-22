import { Card, CardActions, CardContent, CardHeader, Checkbox, Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle, Divider, FormControl, FormControlLabel, FormGroup, Grid, IconButton, makeStyles, Typography } from '@material-ui/core';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import CreateRoundedIcon from '@material-ui/icons/CreateRounded';
import { Skeleton } from '@material-ui/lab';
import { ConfirmDialog, DialogCustom, FieldForm, Button } from 'components';
import React from 'react';
import SortableTree from 'react-sortable-tree';
import 'react-sortable-tree/style.css';
import { copyArray } from 'utils/helper';

const useStyles = makeStyles((theme) => ({
    root: {
        flexGrow: 1,
        '& .MuiCardHeader-root': {
            background: theme.palette.background.selected
        },
        '& .rst__rowLandingPad': {
            opacity: 1,
            backgroundColor: '#ebf2fc',
            borderRadius: 5,
            border: '1px dashed #5a9ae5 !important',
        },
        '& .rst__nodeContent': {
            right: 0
        },
        '& .rst__collapseButton, & .rst__expandButton': {
            boxShadow: 'none',
            border: '1px solid #bdbdbd',
        },
        '& .rst__lineHalfHorizontalRight::before,& .rst__lineFullVertical::after,& .rst__lineHalfVerticalTop::after,& .rst__lineHalfVerticalBottom::after,& .rst__lineChildren::after': {
            backgroundColor: theme.palette.dividerDark,
        },
        '& .rst__row': {
            overflow: 'hidden',
            borderRadius: 5,
            boxShadow: '1px 1px 5px rgba(0, 0, 0, 0.2)',
        },
        '& .rst__rowContents': {
            borderRadius: '0 5px 5px 0',
            padding: 0,
            backgroundColor: theme.palette.background.selected,
            borderColor: theme.palette.dividerDark,
        },
        '& .rst__moveHandle,& .rst__loadingHandle': {
            background: theme.palette.background.default + " url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RTdBRUU5M0M3Njg3MTFFQkE5M0NCOUZFMTM3NzdBOEEiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RTdBRUU5M0Q3Njg3MTFFQkE5M0NCOUZFMTM3NzdBOEEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpFN0FFRTkzQTc2ODcxMUVCQTkzQ0I5RkUxMzc3N0E4QSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpFN0FFRTkzQjc2ODcxMUVCQTkzQ0I5RkUxMzc3N0E4QSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PmMpG7UAAACmSURBVHja7NgxDoAgDAVQazwbd4bLYZxMcMC5fV1I3PosTfgx5zwq13kULwAAAAAAAAAAAABV61o/jDGeI+sDIVpr2wnI/DqargAAAAAAbAAicb+f3mLNBCMi9R9f+3UFAAAAAACAPOCt3nvqPODPBMgD7AAAAADIA+QB8gA7AAAAAAAAyAPkAfIAOwAAAADygCp5gAkAAAAAAAAAAAAAAKBE3QIMADtvIs1XDohhAAAAAElFTkSuQmCC') no-repeat center",
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
        '& .icon-remove': {
            color: '#8b8b8b',
            opacity: 0.5,
        },
        '& .icon-remove:hover': {
            color: '#dd0000',
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


function EditMenu({ tree, setTree, listMenu, listPostType, setListMenu, saveChanges, deleteMenu, location, setLocation, changeMenuEdit }) {

    const classes = useStyles();

    const [menuItemEdit, setMenuItemEdit] = React.useState({ open: false, menuItem: {} });
    const [confirmDelete, setConfirmDelete] = React.useState(false);
    const [confirmDeleteMenu, setConfirmDeleteMenu] = React.useState(false);
    const [menuTemp, setMenuTemp] = React.useState(false);

    const editMenuItem = (rowInfo) => {
        setMenuItemEdit({ open: true, menuItem: copyArray(rowInfo.node) });
        rowInfo.node.edit = true;
    };

    const handleClose = () => {
        clearFlagEditMenu(tree);
        setMenuItemEdit({ ...menuItemEdit, open: false });
    };

    const applyMenuItem = () => {
        let treeTemp = changeEditMenuItem(tree);
        setTree([...treeTemp]);
        setMenuItemEdit({ ...menuItemEdit, open: false });
    }

    const changeEditMenuItem = (items) => {
        for (let index = 0; index < items.length; index++) {
            let menu = items[index];
            if (menu.edit) {
                items[index] = { ...menuItemEdit.menuItem };
            } else {
                if (menu.children) {
                    items[index].children = changeEditMenuItem(menu.children);
                }
            }
        }
        return items;
    };

    const clearFlagEditMenu = (items) => {
        items.forEach(menu => {
            if (menu.edit) {
                menu.edit = false;
            }
            if (menu.children) {
                clearFlagEditMenu(menu.children);
            }
        });

        return items;
    }

    const removeElementDelete = (items) => {

        items.forEach((item, index) => {

            if (item.delete) {
                items.splice(index, 1);
            } else if (item.children) {
                removeElementDelete(item.children);
            }

        });
    };


    const removeMenuItem = (rowInfo) => {
        rowInfo.node.delete = true;
        removeElementDelete(tree);
        setTree([...tree]);
        setConfirmDelete(false);
    };

    const closeDialogConfirmDelete = () => {
        setConfirmDelete(false);
    }

    const changeLocation = (e) => {

        let key = e.target.name;

        if (e.target.checked) {
            setLocation({ ...location, [key]: { ...location[key], contentMenu: listMenu.value } });
        } else {
            setLocation({ ...location, [key]: { ...location[key], contentMenu: 0 } });
        }
    }

    const handleClickLocation = (id) => {

        if (id && listMenu.value * 1 !== id * 1) {
            changeMenuEdit(id * 1);
        }
    }


    if (!listPostType) {
        return (
            <Card className={classes.root} >
                <CardHeader
                    title=
                    {
                        <Skeleton style={{ margin: '10px 0', transform: 'scale(1, 1)' }} animation="wave" height={32} />
                    }
                />
                <CardContent>
                    <div>
                        <Skeleton style={{ margin: '10px 0', transform: 'scale(1, 1)' }} animation="wave" height={32} />

                        <Skeleton style={{ margin: '10px 0', transform: 'scale(1, 1)' }} animation="wave" height={16} />
                        <div style={{ minHeight: 100 }}>
                            {
                                [...Array(5)].map((key, index) => {
                                    return <Skeleton key={index} style={{ margin: '10px 0', transform: 'scale(1, 1)' }} animation="wave" height={48} />
                                })
                            }
                        </div>
                    </div>
                    <Skeleton style={{ margin: '10px 0', transform: 'scale(1, 1)' }} animation="wave" height={48} />
                </CardContent>
                <Divider />
                <CardActions style={{ justifyContent: 'space-between', background: '#f6f7f9' }}>
                    <Skeleton style={{ width: '100%', margin: '10px 0', transform: 'scale(1, 1)' }} animation="wave" height={32} />
                </CardActions>
            </Card>
        )
    }


    return (
        <>
            <Card className={classes.root} >
                <CardHeader
                    title=
                    {
                        <>
                            <div style={{ display: 'flex', alignItems: 'center' }}>
                                <span>
                                    <FieldForm
                                        compoment='text'
                                        config={{
                                            title: 'Menu Name',
                                            size: 'small'
                                        }}
                                        post={{ menuName: listMenu.title ? listMenu.title : '[Menu Name]' }}
                                        name='menuName'
                                        onReview={(value) => { setListMenu({ ...listMenu, title: value ? value : '[Menu Name]' }) }}
                                    />
                                </span>
                            </div>

                        </>
                    }
                />
                <CardContent>
                    <div>
                        <Typography variant='h3'>Menu Structure</Typography>
                        <Typography variant='body2'>
                            Drag each item into the order you want. Click the arrow to the right of the item to display more configuration options.
                        </Typography>
                        <br />
                        <div style={{ minHeight: 100 }}>
                            {
                                tree.length ?
                                    <SortableTree
                                        isVirtualized={false}
                                        treeData={tree}
                                        rowHeight={70}
                                        onChange={(treeData => { setTree(treeData) })}
                                        generateNodeProps={(rowInfo) => ({
                                            title: (
                                                <Typography onClick={() => editMenuItem(rowInfo)} variant='h6'>{rowInfo.node.label}<small>{rowInfo.node.description}</small></Typography>
                                            ),
                                            buttons: [
                                                <Typography variant='body1'>{rowInfo.node.label_type}</Typography>,
                                                <IconButton
                                                    // onClick={() => removeMenuItem(rowInfo)}
                                                    className="icon-remove"
                                                    onClick={() => setConfirmDelete(rowInfo)}
                                                    aria-label="Revemo menu" component="span">
                                                    <ClearRoundedIcon fontSize="small" />
                                                </IconButton>
                                            ],
                                        })}
                                    />
                                    : <></>
                            }
                        </div>
                    </div>
                    < br />
                    <Typography variant='h3'>Display location</Typography>

                    <FormControl required component="fieldset">
                        <FormGroup className={classes.fieldLocation}>

                            {
                                location &&
                                Object.keys(location).map(key => (
                                    <div key={key}>
                                        <FormControlLabel
                                            control={<Checkbox name={key} value={1} checked={Boolean(location[key].contentMenu && (listMenu.value * 1 === location[key].contentMenu * 1))} onChange={changeLocation} color="primary" />}
                                            label={location[key].title}
                                        />
                                        {
                                            location[key].contentMenu && (listMenu.value * 1 !== location[key].contentMenu * 1) ?
                                                <IconButton size="small" onClick={e => handleClickLocation(location[key].contentMenu)} aria-label="delete" color='primary' >
                                                    <CreateRoundedIcon fontSize="small" />
                                                </IconButton>
                                                : null
                                        }
                                    </div>
                                ))
                            }
                        </FormGroup>
                    </FormControl>

                </CardContent>
                <Divider />
                <CardActions style={{ justifyContent: 'space-between' }}>
                    <div>
                        <Button variant="contained" onClick={() => setConfirmDeleteMenu(true)} style={{ color: '#ba000d', marginRight: 8 }}>Delete</Button>
                        {
                            tree ?
                                <Button variant="contained" onClick={() => { setMenuTemp([...tree]); setTree(false) }} style={{ color: '#ba000d' }}>Clear</Button>
                                :
                                <Button variant="contained" onClick={() => { setTree([...menuTemp]) }} style={{ color: '#43a047' }}>Restore</Button>
                        }
                    </div>
                    <Button
                        onClick={saveChanges}
                        type="submit"
                        color="success"
                        variant="contained">
                        Save Changes
                    </Button>
                </CardActions>
            </Card>

            <DialogCustom
                open={menuItemEdit.open}
                onClose={handleClose}
                scroll='paper'
                maxWidth='xs'
                aria-labelledby="scroll-dialog-title"
                aria-describedby="scroll-dialog-description"
                fullWidth
                className={classes.disableOutline}
                title={'Menu Item ' + (menuItemEdit.menuItem.label_type ? '(' + menuItemEdit.menuItem.label_type + ')' : '')}
                action={
                    <>
                        <Button onClick={handleClose}>Cancel</Button>
                        <Button onClick={applyMenuItem} color="primary">Apply</Button>
                    </>
                }
            >

                <Grid
                    container
                    spacing={3}>
                    {
                        menuItemEdit.menuItem.links &&
                        <Grid item md={12} xs={12}>
                            <FieldForm
                                compoment='text'
                                config={{
                                    title: 'URL',
                                }}
                                post={menuItemEdit.menuItem}
                                name='links'
                                onReview={() => { }}
                            />
                        </Grid>
                    }

                    <Grid item md={12} xs={12}>
                        <FieldForm
                            compoment='text'
                            config={{
                                title: 'Navigation Label',
                            }}
                            post={menuItemEdit.menuItem}
                            name='label'
                            onReview={() => { }}
                        />
                    </Grid>

                    <Grid item md={12} xs={12}>
                        <FieldForm
                            compoment='text'
                            config={{
                                title: 'Title Attribute',
                            }}
                            post={menuItemEdit.menuItem}
                            name='attrtitle'
                            onReview={() => { }}
                        />
                    </Grid>

                    <Grid item md={12} xs={12}>
                        <FieldForm
                            compoment='true_false'
                            config={{
                                title: 'Open link in a new tab',
                            }}
                            post={menuItemEdit.menuItem}
                            name='target'
                            onReview={() => { }}
                        />
                    </Grid>

                    <Grid item md={6} xs={12}>
                        <FieldForm
                            compoment='text'
                            config={{
                                title: 'CSS Classes (optional)',
                            }}
                            post={menuItemEdit.menuItem}
                            name='classes'
                            onReview={() => { }}
                        />
                    </Grid>
                    <Grid item md={6} xs={12}>
                        <FieldForm
                            compoment='text'
                            config={{
                                title: 'Link Relationship (XFN)',
                            }}
                            post={menuItemEdit.menuItem}
                            name='xfn'
                            onReview={() => { }}
                        />
                    </Grid>

                    <Grid item md={12} xs={12}>
                        <FieldForm
                            compoment='textarea'
                            config={{
                                title: 'Description',
                                note: 'The description will be displayed in the menu if the current theme supports it.'
                            }}
                            post={menuItemEdit.menuItem}
                            name='description'
                            onReview={() => { }}
                        />
                    </Grid>

                    <Grid item md={12} xs={12}>
                        <FieldForm
                            compoment='flexible'
                            config={{
                                title: 'More information',
                                templates: {
                                    text: {
                                        title: 'Text',
                                        items: {
                                            value: { title: 'Text' }
                                        }
                                    },
                                    textarea: {
                                        title: 'Textarea',
                                        items: {
                                            value: { title: 'Text', view: 'textarea' }
                                        }
                                    },
                                    image: {
                                        title: 'Image',
                                        items: {
                                            value: { title: 'Image', view: 'image' }
                                        }
                                    },
                                    gallery: {
                                        title: 'Gallery',
                                        items: {
                                            value: { title: 'Gallery', view: 'image', multiple: true }
                                        }
                                    }
                                }
                            }}
                            post={menuItemEdit.menuItem}
                            name='more_information'
                            onReview={() => { }}
                        />
                    </Grid>

                </Grid>
            </DialogCustom>

            <ConfirmDialog
                name='delete-menu-item'
                open={confirmDelete !== false}
                onClose={closeDialogConfirmDelete}
                onConfirm={() => { removeMenuItem(confirmDelete) }}
            />

            <ConfirmDialog
                name='delete-menu'
                open={confirmDeleteMenu !== false}
                onClose={() => setConfirmDeleteMenu(false)}
                onConfirm={() => { deleteMenu(); setConfirmDeleteMenu(false); }}
            />

        </>
    )
}

export default EditMenu
