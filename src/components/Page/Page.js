/* eslint-disable no-undef */
import React from 'react'
import { Helmet } from 'react-helmet'
import PropTypes from 'prop-types'
import {makeStyles} from '@material-ui/core'



const useStyles = makeStyles((theme) => ({

    root: {
        maxWidth: '100%',
        margin: '0 auto',
        padding: theme.spacing(3),
    },
    rootlg:{
        width: theme.breakpoints.values.lg,
    },
    rootXl:{
        width: theme.breakpoints.values.xl,
    },

}));

const Page = (props) => {
    const { title, children,width, ...rest} = props
    const classes = useStyles();
    return (
        <div className={classes.root + ' ' + ( width === 'xl' ?  classes.rootXl :  classes.rootlg ) }>
            <div {...rest}>
                <Helmet>
                    <title>{title} - Vn4CMS</title>
                </Helmet>
                {children}
            </div>
        </div>
    )
}

Page.propTypes = {
    children: PropTypes.node,
    title: PropTypes.string,
}

export default Page
