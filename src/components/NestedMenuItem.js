import { makeStyles, Menu, MenuItem, Typography } from '@material-ui/core';
import React, { useState, useRef, useImperativeHandle } from 'react'
import ArrowRight from '@material-ui/icons/ArrowRight'
import clsx from 'clsx'

const useStyles = makeStyles((theme) => ({
    menuFile: {
        userSelect: 'none',
        maxHeight: 500,
        maxWidth: 400,
        minWidth: 320,
        '& .MuiListItem-button': {
            height: 38,
        },
    },
    menuPopover: {
        '& .MuiPopover-paper': {
            transform: 'var(--transform)',
            pointerEvents: 'all',
        }
    },
}));


function NestedMenu() {

    const classes = useStyles();

    const [anchorEl, setAnchorEl] = React.useState({
        rel: null
    });

    const [menuPosition, setMenuPosition] = React.useState({ top: 10, left: 10 })
    const menuItemRef = React.useRef(null)

    const handleRightClick = (event) => {
        if (menuPosition) {
            return
        }
        event.preventDefault()
        setMenuPosition({
            top: event.pageY,
            left: event.pageX
        })
    }

    const handleItemClick = (event) => {
        setMenuPosition(null)
    }

    return <div onContextMenu={handleRightClick}>
        <Typography>Right click to open menu</Typography>
        <Menu
            open={!!menuPosition}
            onClose={() => setMenuPosition(null)}
            anchorReference='anchorPosition'
            anchorPosition={menuPosition}
        >
            <MenuItem onClick={handleItemClick}>Button 1</MenuItem>
            <MenuItem onClick={handleItemClick}>Button 2</MenuItem>
            <NestedMenuItem
                ref={menuItemRef}
                label='Button 3'
                parentMenuOpen={!!menuPosition}
                onClick={handleItemClick}
            >
                <MenuItem onClick={handleItemClick}>Sub-Button 1</MenuItem>
                <MenuItem onClick={handleItemClick}>Sub-Button 2</MenuItem>
                <NestedMenuItem
                    label='Sub-Button 3'
                    parentMenuOpen={!!menuPosition}
                    onClick={handleItemClick}
                >
                    <MenuItem onClick={handleItemClick}>Sub-Sub-Button 1</MenuItem>
                    <MenuItem onClick={handleItemClick}>Sub-Sub-Button 2</MenuItem>
                </NestedMenuItem>
            </NestedMenuItem>
            <MenuItem onClick={handleItemClick}>Button 4</MenuItem>
        </Menu>
    </div>
}

export default NestedMenu


const TRANSPARENT = 'rgba(0,0,0,0)'
const useMenuItemStyles = makeStyles((theme) => ({
  root: (props) => ({
    backgroundColor: props.open ? theme.palette.action.hover : TRANSPARENT
  })
}));
/**
 * Use as a drop-in replacement for `<MenuItem>` when you need to add cascading
 * menu elements as children to this component.
 */
const NestedMenuItem = React.forwardRef(function NestedMenuItem(props, ref) {
    const {
        parentMenuOpen,
        component = 'div',
        label,
        rightIcon = <ArrowRight />,
        children,
        className,
        tabIndex: tabIndexProp,
        MenuProps = {},
        ContainerProps: ContainerPropsProp = {},
        ...MenuItemProps
    } = props

    const { ref: containerRefProp, ...ContainerProps } = ContainerPropsProp

    const menuItemRef = useRef(null)
    useImperativeHandle(ref, () => menuItemRef.current)

    const containerRef = useRef(null)
    useImperativeHandle(containerRefProp, () => containerRef.current)

    const menuContainerRef = useRef(null)

    const [isSubMenuOpen, setIsSubMenuOpen] = useState(false)

    const handleMouseEnter = (event) => {
        setIsSubMenuOpen(true)

        if (ContainerProps?.onMouseEnter) {
            ContainerProps.onMouseEnter(event)
        }
    }
    const handleMouseLeave = (event) => {
        setIsSubMenuOpen(false)

        if (ContainerProps?.onMouseLeave) {
            ContainerProps.onMouseLeave(event)
        }
    }

    // Check if any immediate children are active
    const isSubmenuFocused = () => {
        const active = containerRef.current?.ownerDocument?.activeElement
        for (const child of menuContainerRef.current?.children ?? []) {
            if (child === active) {
                return true
            }
        }
        return false
    }

    const handleFocus = (event) => {
        if (event.target === containerRef.current) {
            setIsSubMenuOpen(true)
        }

        if (ContainerProps?.onFocus) {
            ContainerProps.onFocus(event)
        }
    }

    const handleKeyDown = (event) => {
        if (event.key === 'Escape') {
            return
        }

        if (isSubmenuFocused()) {
            event.stopPropagation()
        }

        const active = containerRef.current?.ownerDocument?.activeElement

        if (event.key === 'ArrowLeft' && isSubmenuFocused()) {
            containerRef.current?.focus()
        }

        if (
            event.key === 'ArrowRight' &&
            event.target === containerRef.current &&
            event.target === active
        ) {
            const firstChild = menuContainerRef.current?.children[0]
        }
    }

    const open = isSubMenuOpen && parentMenuOpen
    const menuItemClasses = useMenuItemStyles({ open })

    // Root element must have a `tabIndex` attribute for keyboard navigation
    let tabIndex
    if (!props.disabled) {
        tabIndex = tabIndexProp !== undefined ? tabIndexProp : -1
    }

    return (
        <div
            {...ContainerProps}
            ref={containerRef}
            onFocus={handleFocus}
            tabIndex={tabIndex}
            onMouseEnter={handleMouseEnter}
            onMouseLeave={handleMouseLeave}
            onKeyDown={handleKeyDown}
        >
            <MenuItem
                {...MenuItemProps}
                className={clsx(menuItemClasses.root, className)}
                ref={menuItemRef}
            >
                {label}
                {rightIcon}
            </MenuItem>
            <Menu
                // Set pointer events to 'none' to prevent the invisible Popover div
                // from capturing events for clicks and hovers
                style={{ pointerEvents: 'none' }}
                anchorEl={menuItemRef.current}
                anchorOrigin={{
                    vertical: 'top',
                    horizontal: 'right'
                }}
                transformOrigin={{
                    vertical: 'top',
                    horizontal: 'left'
                }}
                open={open}
                autoFocus={false}
                disableAutoFocus
                disableEnforceFocus
                onClose={() => {
                    setIsSubMenuOpen(false)
                }}
            >
                <div ref={menuContainerRef} style={{ pointerEvents: 'auto' }}>
                    {children}
                </div>
            </Menu>
        </div>
    )
})