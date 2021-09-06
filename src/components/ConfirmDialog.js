import { Button, Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle } from '@material-ui/core'
import React from 'react'

function ConfirmDialog({ open, onClose, onConfirm, message = 'Are you sure you want to permanently remove this item?' }) {
    return (
        <Dialog
            open={open}
            onClose={onClose}
            aria-labelledby="alert-dialog-title"
            aria-describedby="alert-dialog-description">
            <DialogTitle id="alert-dialog-title">{"Confirm Deletion"}</DialogTitle>
            <DialogContent>
                <DialogContentText id="alert-dialog-description">
                    {message}
                </DialogContentText>
            </DialogContent>
            <DialogActions>
                <Button onClick={onConfirm} color="primary">
                    OK
                    </Button>
                <Button onClick={onClose} color="default" autoFocus>
                    Cancel
                    </Button>
            </DialogActions>
        </Dialog>
    )
}

export default ConfirmDialog
