import React from 'react'
import clsx from 'clsx'
import { makeStyles } from '@material-ui/styles'
import { Drawer, Grid, Typography, Button, Hidden, Dialog, DialogTitle, DialogContent, DialogContentText, DialogActions } from '@material-ui/core'
import CloseIcon from '@material-ui/icons/Close'
import DeleteIcon from '@material-ui/icons/DeleteOutline'
import RestoreIcon from '@material-ui/icons/Restore';

const useStyles = makeStyles((theme) => ({
    shadow: {
        '& .MuiDrawer-paperAnchorDockedBottom': {
            boxShadow: '0px -2px 4px -1px rgb(0 0 0 / 20%), 0px -4px 5px 0px rgb(0 0 0 / 14%), 0px -1px 10px 0px rgb(0 0 0 / 12%)',
        }
    },
    root: {
        padding: theme.spacing(2),
    },
    actions: {
        display: 'flex',
        justifyContent: 'center',
        flexWrap: 'wrap',
        '& > * + *': {
            marginLeft: theme.spacing(2),
        },
    },
    buttonIcon: {
        marginRight: theme.spacing(1),
    },
}))

const TableEditBar = (props) => {
    const {
        selected,
        className,
        acctionPost,
        setSelectedCustomers,
        ...rest
    } = props

    const classes = useStyles()
    const open = selected.length > 0;

    const [confirmDelete, setConfirmDelete] = React.useState(false);

    const handelOnClickDelete = () => {
        setConfirmDelete(true);
    };

    const closeDialogConfirmDelete = () => {
        setConfirmDelete(false);
    };

    return (
        <>

            <Drawer
                anchor="bottom"
                open={open}
                // eslint-disable-next-line react/jsx-sort-props
                PaperProps={{ elevation: 1 }}
                className={classes.shadow}
                variant="persistent">
                <div {...rest} className={clsx(classes.root, className)}>
                    <Grid alignItems="center" container spacing={2}>
                        <Hidden smDown>
                            <Grid item md={3}>
                                <Typography
                                    color="textSecondary"
                                    variant="subtitle1">
                                    {selected.length} selected
                            </Typography>
                            </Grid>
                        </Hidden>
                        <Grid item md={6} xs={12}>
                            <div className={classes.actions}>
                                <Button onClick={() => acctionPost({ trash: selected }, () => setSelectedCustomers([]))}>
                                    <DeleteIcon className={classes.buttonIcon} />
                                    Move to Trash
                                </Button>
                                <Button style={{ color: '#43a047' }} onClick={() => acctionPost({ restore: selected }, () => setSelectedCustomers([]))}>
                                    <RestoreIcon className={classes.buttonIcon} />
                                    Restore
                                </Button>
                                <Button color="secondary" onClick={() => setConfirmDelete(true)}>
                                    <CloseIcon className={classes.buttonIcon} />
                                    Delete forever
                                </Button>
                            </div>
                        </Grid>
                    </Grid>
                </div>
            </Drawer>
            <Dialog
                open={confirmDelete}
                onClose={closeDialogConfirmDelete}
                aria-labelledby="alert-dialog-title"
                aria-describedby="alert-dialog-description">
                <DialogTitle id="alert-dialog-title">{"Confirm Deletion"}</DialogTitle>
                <DialogContent>
                    <DialogContentText id="alert-dialog-description">
                        Are you sure you want to permanently remove this item?
                    </DialogContentText>
                </DialogContent>
                <DialogActions>
                    <Button onClick={() => acctionPost({ delete: selected }, () => { setSelectedCustomers([]); closeDialogConfirmDelete() })} color="default">
                        OK
                    </Button>
                    <Button onClick={closeDialogConfirmDelete} color="primary" autoFocus>
                        Cancel
                    </Button>
                </DialogActions>
            </Dialog>
        </>
    )
}

export default TableEditBar
