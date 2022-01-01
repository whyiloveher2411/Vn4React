import React from 'react'
import { Link } from 'react-router-dom'
import NavigateNextIcon from '@material-ui/icons/NavigateNext';
import { ListItemIcon, ListItemText, Menu, MenuItem } from '@material-ui/core';
import SettingsOutlined from '@material-ui/icons/SettingsOutlined';
import BarChart from '@material-ui/icons/BarChart';
import TimelineIcon from '@material-ui/icons/Timeline';

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
            <span className="link" onClick={handleClick}>Analytics</span>
            <Menu
                id="simple-menu"
                anchorEl={anchorEl}
                keepMounted
                open={Boolean(anchorEl)}
                onClose={handleClose}
            >

                <MenuItem onClick={handleClose}
                    component={Link}
                    to="/settings/google-analytics/analytics"
                >
                    <ListItemIcon>
                        <SettingsOutlined fontSize="small" />
                    </ListItemIcon>
                    <ListItemText primary="Settings" />
                </MenuItem>
                
                <MenuItem onClick={handleClose}
                     component={Link}
                     to="/plugin/vn4-google-analytics/reports"
                >
                    <ListItemIcon>
                        <TimelineIcon fontSize="small" />
                    </ListItemIcon>
                    <ListItemText primary="Reports" />
                </MenuItem>

                
                <MenuItem onClick={handleClose}
                     component={Link}
                     to="/plugin/vn4-google-analytics/realtime"
                >
                    <ListItemIcon>
                        <BarChart fontSize="small" />
                    </ListItemIcon>
                    <ListItemText primary="Realtime" />
                </MenuItem>
            </Menu>
        </>
    )
}

export default LinkSetting
