import React from 'react'
import { Link } from 'react-router-dom'
import NavigateNextIcon from '@material-ui/icons/NavigateNext';
import { ListItemIcon, ListItemText, Menu, MenuItem } from '@material-ui/core';
import SettingsOutlined from '@material-ui/icons/SettingsOutlined';
import TimelineIcon from '@material-ui/icons/Timeline';
import DonutSmallRoundedIcon from '@material-ui/icons/DonutSmallRounded';

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
            <span className="link" onClick={handleClick}>SEO</span>
            <Menu
                id="simple-menu"
                anchorEl={anchorEl}
                keepMounted
                open={Boolean(anchorEl)}
                onClose={handleClose}
            >

                <MenuItem onClick={handleClose}
                    component={Link}
                    to="/plugin/vn4seo/settings"
                >
                    <ListItemIcon>
                        <SettingsOutlined fontSize="small" />
                    </ListItemIcon>
                    <ListItemText primary="Settings" />
                </MenuItem>

                <MenuItem onClick={handleClose}
                    component={Link}
                    to="/plugin/vn4seo/performance"
                >
                    <ListItemIcon>
                        <TimelineIcon fontSize="small" />
                    </ListItemIcon>
                    <ListItemText primary="Performance" />
                </MenuItem>
                <MenuItem onClick={handleClose}
                    component={Link}
                    to="/plugin/vn4seo/measure/performance"
                >
                    <ListItemIcon>
                        <DonutSmallRoundedIcon fontSize="small" />
                    </ListItemIcon>
                    <ListItemText primary="Measure" />
                </MenuItem>
            </Menu>
        </>
    )
}

export default LinkSetting

