import DialogActions from '@material-ui/core/DialogActions';
import Dialog from '@material-ui/core/Dialog';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import React from 'react';

function DialogCustom({ title, content, action, open, onClose, children, ...rest }) {

    return (
        <Dialog
            open={open}
            onClose={onClose}
            scroll='paper'
            aria-labelledby="scroll-dialog-title"
            aria-describedby="scroll-dialog-description"
            fullWidth
            {...rest}
        >
            <DialogTitle disableTypography={true} style={{ fontSize: 22, background: '#455a64', color: 'white' }}>{title}</DialogTitle>
            <DialogContent dividers={true} className="custom_scroll" style={rest.style ?? {}}>
                <DialogContentText
                    component="div"
                    style={{ margin: 0 }}
                >
                    {content}
                    {children}
                </DialogContentText>
            </DialogContent>
            {
                Boolean(action) &&
                <DialogActions>
                    {action}
                </DialogActions>
            }

        </Dialog>
    )
}

export default DialogCustom
