import { Button, Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle } from '@material-ui/core'
import React from 'react'
import { __ } from 'utils/i18n'

function ConfirmDialog({ open, onClose, onConfirm, message = __('Are you sure you want to permanently remove this item?') }) {
    return (
        <Dialog
            open={open}
            onClose={onClose}
            aria-labelledby="alert-dialog-title"
            aria-describedby="alert-dialog-description">
            <DialogTitle id="alert-dialog-title">{__('Confirm Deletion')}</DialogTitle>
            <DialogContent>
                <DialogContentText id="alert-dialog-description">
                    {message}
                </DialogContentText>
            </DialogContent>
            <DialogActions>
                <Button onClick={onConfirm} color="primary">
                    {__('OK')}
                </Button>
                <Button onClick={onClose} color="default" autoFocus>
                    {__('Cancel')}
                </Button>
            </DialogActions>
        </Dialog>
    )
}

export default ConfirmDialog
