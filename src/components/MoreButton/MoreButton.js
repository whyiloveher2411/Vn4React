import {
    IconButton, ListItemIcon,
    ListItemText, Menu,
    MenuItem, Tooltip
} from '@material-ui/core'
import MoreIcon from '@material-ui/icons/MoreVert'
import { makeStyles } from '@material-ui/styles'
import { MaterialIcon } from 'components'
import React, { Fragment, memo, useRef, useState } from 'react'

const useStyles = makeStyles(() => ({}))

const MoreButton = ({ title, action, selected, ...rest }) => {
    const classes = useStyles()
    const moreRef = useRef(null)
    const [openMenu, setOpenMenu] = useState(false)

    const handleMenuOpen = () => {
        setOpenMenu(true)
    }

    const handleMenuClose = () => {
        setOpenMenu(false)
    }

    return (
        <Fragment>
            <Tooltip title={title ?? "More actions"}>
                <IconButton
                    onClick={handleMenuOpen}
                    ref={moreRef}
                    size="small">
                    <MoreIcon />
                </IconButton>
            </Tooltip>
            <Menu
                anchorEl={moreRef.current}
                classes={{ paper: classes.menu }}
                onClose={handleMenuClose}
                open={openMenu}
                {...rest}
            >
                {
                    action.map(group => (
                        Object.keys(group).map(key => (
                            <MenuItem selected={key === selected} onClick={group[key].action}>
                                {
                                    group[key].icon ?
                                        <ListItemIcon>
                                            <MaterialIcon icon={group[key].icon} />
                                        </ListItemIcon>
                                        : <></>
                                }
                                <ListItemText primary={group[key].title} />
                            </MenuItem>
                        ))
                    ))
                }
            </Menu>
        </Fragment>
    )
}

export default memo(MoreButton)
