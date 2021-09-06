import { Button, Collapse, colors, ListItem, SvgIcon } from '@material-ui/core';
import ExpandLessIcon from '@material-ui/icons/ExpandLess';
import ExpandMoreIcon from '@material-ui/icons/ExpandMore';
import { makeStyles } from '@material-ui/styles';
import clsx from 'clsx';
import PropTypes from 'prop-types';
import React, { useState } from 'react';
import {
    NavLink
} from "react-router-dom";
import { MaterialIcon } from '../components';
import { default as LabelTab } from '../components/Label';

const NavigationListItem = props => {

    const {
        title,
        href,
        depth,
        children,
        icon: Icon,
        className,
        open: openProp,
        label: Label,
        svgIcon: svgIcon,
        ...rest
    } = props;

    const classes = useStyles();
    const [open, setOpen] = useState(openProp);

    const handleToggle = () => {
        setOpen(open => !open);
    };

    let paddingLeft = 8;

    if (depth > 0) {
        paddingLeft = 32 + 8 * depth;
    }

    const style = {
        paddingLeft
    };

    if (children) {
        return (
            <ListItem
                {...rest}
                className={clsx(classes.item, className)}
                disableGutters
            >
                <Button
                    className={classes.button}
                    onClick={handleToggle}
                    style={style}
                >
                    {svgIcon ?
                        <SvgIcon className={classes.icon}>
                            <svg dangerouslySetInnerHTML={{ __html: svgIcon }} />
                        </SvgIcon>
                        :
                        <MaterialIcon icon={Icon} className={classes.icon} />
                    }
                    {title}
                    {open ? (
                        <ExpandLessIcon
                            className={classes.expandIcon}
                            color="inherit"
                        />
                    ) : (
                        <ExpandMoreIcon
                            className={classes.expandIcon}
                            color="inherit"
                        />
                    )}
                </Button>
                <Collapse in={open}>{children}</Collapse>
            </ListItem>
        );
    } else {
        return (
            <ListItem
                {...rest}
                className={clsx(classes.itemLeaf, className)}
                disableGutters
            >
                {href ?
                    <Button
                        className={clsx(classes.buttonLeaf, `depth-${depth}`)}
                        activeClassName={classes.active}
                        style={style}
                        component={NavLink}
                        to={href}>
                        {svgIcon ?
                            <SvgIcon className={classes.icon}>
                                <svg dangerouslySetInnerHTML={{ __html: svgIcon }} />
                            </SvgIcon>
                            :
                            <MaterialIcon icon={Icon} className={classes.icon} />
                        }
                        {title}
                        {Label && <LabelTab {...Label} className={classes.iconExpand + ' ' + classes.label}>{Label.title}</LabelTab>}
                    </Button>
                    :
                    <Button
                        className={clsx(classes.buttonLeaf, `depth-${depth}`)}
                        style={style}
                        to={href}>
                        {svgIcon ?
                            <SvgIcon className={classes.icon}>
                                <svg dangerouslySetInnerHTML={{ __html: svgIcon }} />
                            </SvgIcon>
                            :
                            <MaterialIcon icon={Icon} className={classes.icon} />
                        }
                        {title}
                        {Label && <LabelTab {...Label} className={classes.iconExpand + ' ' + classes.label}>{Label.title}</LabelTab>}
                    </Button>
                }
            </ListItem>
        );
    }
};

NavigationListItem.propTypes = {
    children: PropTypes.node,
    className: PropTypes.string,
    depth: PropTypes.number.isRequired,
    href: PropTypes.string,
    icon: PropTypes.any,
    label: PropTypes.any,
    open: PropTypes.bool,
    title: PropTypes.string.isRequired
};

NavigationListItem.defaultProps = {
    depth: 0,
    open: false
};

export default NavigationListItem;



const useStyles = makeStyles(theme => ({
    item: {
        display: 'block',
        paddingTop: 0,
        paddingBottom: 0
    },
    linkItem: {
        display: 'flex',
        textDecoration: 'none',
        color: 'inherit',
        width: '100%'
    },
    itemLeaf: {
        display: 'flex',
        paddingTop: 0,
        paddingBottom: 0
    },
    button: {
        color: colors.blueGrey[800],
        padding: '10px 8px',
        justifyContent: 'flex-start',
        textTransform: 'none',
        letterSpacing: 0,
        width: '100%'
    },
    buttonLeaf: {
        color: colors.blueGrey[800],
        padding: '10px 8px',
        justifyContent: 'flex-start',
        textTransform: 'none',
        letterSpacing: 0,
        width: '100%',
        fontWeight: theme.typography.fontWeightRegular,
        '&.depth-0': {
            fontWeight: theme.typography.fontWeightMedium
        }
    },
    icon: {
        color: theme.palette.icon,
        display: 'flex',
        alignItems: 'center',
        marginRight: theme.spacing(1)
    },
    expandIcon: {
        marginLeft: 'auto',
        height: 16,
        width: 16
    },
    label: {
        display: 'flex',
        alignItems: 'center',
        marginLeft: 'auto'
    },
    active: {
        color: theme.palette.primary.main,
        fontWeight: theme.typography.fontWeightMedium,
        '& $icon': {
            color: theme.palette.primary.main,
            fontWeight: 500,
        }
    }
}));
