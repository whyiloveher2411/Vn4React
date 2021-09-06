import DialogActions from '@material-ui/core/DialogActions';
import Drawer from '@material-ui/core/Drawer';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import React from 'react';

function DrawerCustom({ title, content, action, open, onClose, children, restDialogContent, titlePadding, ...rest }) {

    return (
        <Drawer
            anchor="right"
            onClose={onClose}
            open={open}
            variant="temporary"
            {...rest}
        >
            <DialogTitle disableTypography={true} style={{ fontSize: 22, background: '#455a64', color: 'white', padding: titlePadding ?? '16px 24px' }}>{title}</DialogTitle>
            <DialogContent className="custom_scroll" {...restDialogContent}>
                <DialogContentText
                    component="div"
                    style={{ height: '100%', margin: 0 }}
                >
                    <div style={{ maxWidth: '100%', height: '100%', width: rest.width ?? 600, margin: '0 auto' }}>
                        {content}
                        {children}
                    </div>
                </DialogContentText>
            </DialogContent>
            {
                Boolean(action) &&
                <DialogActions>
                    {action}
                </DialogActions>
            }

        </Drawer>
    )
}

export default DrawerCustom
