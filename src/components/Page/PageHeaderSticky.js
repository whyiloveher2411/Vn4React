/* eslint-disable no-undef */
import React from 'react'
import { Helmet } from 'react-helmet'
import PropTypes from 'prop-types'
import { Divider, makeStyles } from '@material-ui/core'
import { useSelector } from 'react-redux';

const useStyles = makeStyles((theme) => ({
    root: {
        maxWidth: '100%',
        margin: '0 auto',
        padding: theme.spacing(3),
    },
    headTop: {
        position: 'sticky',
        top: 0,
        background: theme.palette.body.background,
        boxShadow: '2px 0px 0 ' + theme.palette.body.background + ', -2px 0px 0 ' + theme.palette.body.background,
        zIndex: 1000,
    },
    divider: {
        backgroundColor: theme.palette.dividerDark,
        margin: '16px 0',
    },
    rootlg: {
        width: theme.breakpoints.values.lg,
    },
    rootXl: {
        width: theme.breakpoints.values.xl,
    },

}));

const PageHeaderSticky = (props) => {
    const setting = useSelector(s => s.settings);
    const { title = '', children, width, header, ...rest } = props
    const classes = useStyles();
    return (
        <div className={classes.root + ' ' + (width === 'xl' ? classes.rootXl : classes.rootlg)} style={{ width: props.width ?? '' }}>
            <div {...rest}>
                <Helmet>
                    <title>{title} - {setting.general_site_title ?? ''}</title>
                </Helmet>
                <div className={classes.headTop}>
                    {header}
                    <Divider className={classes.divider} />
                </div>
                {children}
            </div>
        </div>
    )
}

PageHeaderSticky.propTypes = {
    children: PropTypes.node,
    title: PropTypes.string,
}

export default PageHeaderSticky
