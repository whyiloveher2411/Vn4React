import { makeStyles } from '@material-ui/core';
import Box from '@material-ui/core/Box';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import Drawer from '@material-ui/core/Drawer';
import IconButton from '@material-ui/core/IconButton';
import Typography from '@material-ui/core/Typography';
import CloseIcon from '@material-ui/icons/Close';
import React from 'react';



const useStyles = makeStyles(theme => ({
    header: {
        display: 'flex',
        justifyContent: 'space-between',
        alignItems: 'center',
        padding: '0 24px',
        backgroundColor: theme.palette.header.background,
        minHeight: 64,
        color: 'white',
        '& .MuiIconButton-root, & .MuiTypography-root': {
            color: 'white',
        }
    },
}));


function DrawerCustom({ title, content, headerAction = false, action, open, onClose, children, restDialogContent, width, ...rest }) {

    const classes = useStyles();

    return (
        <Drawer
            anchor="right"
            onClose={onClose}
            open={open}
            variant="temporary"
            {...rest}
        >
            <DialogTitle className={classes.header} disableTypography={true}>
                <Box display="flex" alignItems="center" gridGap={16}>
                    <IconButton onClick={onClose} aria-label="close">
                        <CloseIcon />
                    </IconButton>
                    <Typography variant="h4">
                        {title}
                    </Typography>
                </Box>
                {
                    headerAction &&
                    <Box display="flex" gridGap={16}>
                        {headerAction}
                    </Box>
                }
            </DialogTitle>
            <DialogContent className="custom_scroll" {...restDialogContent}>
                <DialogContentText
                    component="div"
                    style={{ height: '100%', margin: 0 }}
                >
                    <div style={{ maxWidth: '100%', height: '100%', width: width ?? 600, margin: '0 auto' }}>
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

        </Drawer >
    )
}

export default DrawerCustom
