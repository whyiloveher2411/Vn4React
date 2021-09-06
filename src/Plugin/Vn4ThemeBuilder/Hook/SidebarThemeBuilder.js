import React from 'react'
import { List, ListItemText, ListItem, Divider } from '@material-ui/core';

function SidebarThemeBuilder() {
    return (
        <List component="nav">
            <ListItem button>
                <ListItemText primary="Layout" />
            </ListItem>
            <Divider />
            <ListItem button>
                <ListItemText primary="Basic" />
            </ListItem>
            <Divider />
            <ListItem button>
                <ListItemText primary="Typography" />
            </ListItem>
            <Divider />
            <ListItem button>
                <ListItemText primary="Media" />
            </ListItem>
            <Divider />
            <ListItem button>
                <ListItemText primary="Components" />
            </ListItem>
            <Divider />
        </List>
    )
}

export default SidebarThemeBuilder
