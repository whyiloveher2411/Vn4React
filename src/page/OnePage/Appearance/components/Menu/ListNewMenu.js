import { Box, Button, Card, CardActions, CardContent, Chip, Grid, IconButton, makeStyles, Paper, Table, TableBody, TableCell, TableContainer, TableHead, TableRow } from '@material-ui/core'
import { Skeleton } from '@material-ui/lab';
import { ConfirmDialog, NotFound } from 'components';
import React from 'react'
import { useAjax } from 'utils/useAjax';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import EditOutlinedIcon from '@material-ui/icons/EditOutlined';
import { DialogCustom, FieldForm } from 'components';

const useStyles = makeStyles({
    menu: {
        '&:hover $action': {
            opacity: 1
        }
    },
    action: {
        opacity: 0
    }

});

function ListNewMenu() {

    const [menus, setMenus] = React.useState(false);

    const [confirmDelete, setConfirmDelete] = React.useState({
        title: '',
        id: null,
        open: false
    });

    const [dialogCreateMenu, setDialogCreateMenu] = React.useState({
        title: 'Add new menu',
        name: '',
        description: '',
        action: 'create',
        open: false,
    });

    const useAjax1 = useAjax();
    const classes = useStyles();

    React.useEffect(() => {

        useAjax1.ajax({
            url: 'appearance-menu/list',
            success: (result) => {
                validateMenus(result);
            }
        });

    }, []);

    const validateMenus = (data) => {

        let locationData = {};

        if (data.location) {
            Object.keys(data.location).forEach((key) => {
                if (data.location[key].contentMenu) {
                    if (!locationData['key_' + data.location[key].contentMenu]) {
                        locationData['key_' + data.location[key].contentMenu] = [];
                    }

                    locationData['key_' + data.location[key].contentMenu].push(data.location[key].title);

                }
            });
        }

        if (data.menus) {
            data.menus.forEach(item => {
                if (locationData['key_' + item.id]) {
                    item.locationText = locationData['key_' + item.id].map((local, index) => <><Chip key={index} label={local} />&nbsp;</>);
                }
            });
        } else {
            data.menus = [];
        }


        setMenus(data.menus);
    }


    const handelAddNew = () => {

        if (!useAjax1.open) {
            useAjax1.ajax({
                url: 'appearance-menu/edit',
                data: dialogCreateMenu,
                success: (result) => {
                    validateMenus(result);

                    if (result.success) {
                        setDialogCreateMenu({
                            title: 'Add new menu',
                            name: '',
                            description: '',
                            action: 'create',
                            open: false,
                        });
                    }
                }
            });
        }
    };

    const handleConfirmDeleteMenu = () => {
        if (!useAjax1.open) {
            useAjax1.ajax({
                url: 'appearance-menu/delete',
                data: {
                    id: confirmDelete.id,
                    action: 'delete'
                },
                success: (result) => {
                    validateMenus(result);

                    if (result.success) {
                        setConfirmDelete({
                            ...dialogCreateMenu,
                            open: false
                        });
                    }

                }
            });
        }
    }

    if (menus) {
        return (
            <>
                <Card>
                    {
                        menus.length > 0 ?
                            <TableContainer>
                                <Table>
                                    <TableHead>
                                        <TableRow>
                                            <TableCell>Name</TableCell>
                                            <TableCell>Description</TableCell>
                                            <TableCell>Location</TableCell>
                                            <TableCell></TableCell>
                                        </TableRow>
                                    </TableHead>
                                    <TableBody>
                                        {
                                            menus.map((item) => (
                                                <TableRow className={classes.menu} key={item.id}>
                                                    <TableCell>{item.title}</TableCell>
                                                    <TableCell>{item.description}</TableCell>
                                                    <TableCell>{item.locationText}</TableCell>
                                                    <TableCell padding="checkbox" style={{ width: 'auto' }} align="right">
                                                        <Box className={classes.action}>
                                                            <IconButton onClick={() => setDialogCreateMenu({
                                                                open: true,
                                                                title: 'Edit menu',
                                                                name: item.title,
                                                                description: item.description,
                                                                action: 'edit',
                                                                id: item.id,
                                                            })}>
                                                                <EditOutlinedIcon />
                                                            </IconButton>
                                                            <IconButton onClick={() => { setConfirmDelete({ open: true, id: item.id, title: item.title }) }} className="color-remove">
                                                                <ClearRoundedIcon />
                                                            </IconButton>
                                                        </Box>
                                                    </TableCell>
                                                </TableRow>
                                            ))
                                        }
                                    </TableBody>
                                </Table>
                            </TableContainer>
                            :
                            <>
                                <br />
                                <NotFound>
                                    Nothing To Display. <br />
                                    <span style={{ color: '#ababab', fontSize: '16px' }}>Seems like no Data have been created yet.</span>
                                </NotFound>
                            </>
                    }
                    <CardActions>
                        <Box width={1} gridGap={8} display="flex" justifyContent="flex-end">
                            <Button onClick={() => setDialogCreateMenu({ ...dialogCreateMenu, open: true })} variant="contained" color="primary">Add new</Button>
                        </Box>
                    </CardActions>
                </Card>

                <DialogCustom
                    open={dialogCreateMenu.open}
                    onClose={() => setDialogCreateMenu({ ...dialogCreateMenu, open: false })}
                    title={dialogCreateMenu.title}
                    action={
                        <>
                            <Button onClick={() => setDialogCreateMenu({ ...dialogCreateMenu, open: false })}>Cancel</Button>
                            <Button color="primary" onClick={handelAddNew}>Save Change</Button>
                        </>
                    }
                >
                    <Grid container spacing={3}>
                        <Grid item xs={12}>
                            <FieldForm
                                compoment='text'
                                config={{
                                    title: 'Menu Name',
                                }}
                                post={dialogCreateMenu}
                                name='name'
                                onReview={(value) => { setDialogCreateMenu({ ...dialogCreateMenu, name: value }); }}
                            />
                        </Grid>
                        <Grid item xs={12}>
                            <FieldForm
                                compoment='textarea'
                                config={{
                                    title: 'Description',
                                }}
                                post={dialogCreateMenu}
                                name='description'
                                onReview={(value) => { setDialogCreateMenu({ ...dialogCreateMenu, description: value }); }}
                            />
                        </Grid>
                    </Grid>

                </DialogCustom>

                <ConfirmDialog
                    open={confirmDelete.open}
                    onClose={() => setConfirmDelete({ ...confirmDelete, open: false })}
                    onConfirm={handleConfirmDeleteMenu}
                    message={'Are you sure you want to permanently remove this "' + (confirmDelete ? confirmDelete.title : '') + '" menu?'}
                />
            </>
        )
    }

    return (
        <TableContainer component={Paper}>
            <Table size="small">
                <TableHead>
                    <TableRow>
                        <TableCell ><Skeleton variant="text" height={32} width="100%" /></TableCell>
                        <TableCell><Skeleton variant="text" height={32} width="100%" /></TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {
                        [1, 2, 3, 4, 5, 6].map((item) => (
                            <TableRow key={item}>
                                <TableCell><Skeleton variant="text" height={32} width="100%" /></TableCell>
                                <TableCell><Skeleton variant="text" height={32} width="100%" /></TableCell>
                            </TableRow>
                        ))
                    }
                </TableBody>
            </Table>
        </TableContainer>
    );
}

export default ListNewMenu
