import React from 'react'
import { Link } from 'react-router-dom'
import NavigateNextIcon from '@material-ui/icons/NavigateNext';
import { Button, Menu, MenuItem } from '@material-ui/core';

function LinkSetting() {

    const [anchorEl, setAnchorEl] = React.useState(null);

    const handleClick = (event) => {
        setAnchorEl(event.currentTarget);
    };

    const handleClose = () => {
        setAnchorEl(null);
    };


    return (
        <>
            <NavigateNextIcon fontSize="small" />
            <span className="link" onClick={handleClick}>Open Menu</span>
            <Menu
                id="simple-menu"
                anchorEl={anchorEl}
                keepMounted
                open={Boolean(anchorEl)}
                onClose={handleClose}
            >
                <MenuItem onClick={handleClose}>Profile</MenuItem>
                <MenuItem onClick={handleClose}>My account</MenuItem>
                <MenuItem onClick={handleClose}>Logout</MenuItem>
            </Menu>
        </>
    )
}

export default LinkSetting
