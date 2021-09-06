import { Fab, Grid, IconButton, Tooltip, Typography } from '@material-ui/core'
import { makeStyles } from '@material-ui/styles'
import clsx from 'clsx'
import PropTypes from 'prop-types'
import React from 'react'
import { Link } from 'react-router-dom'
import { checkPermission } from 'utils/user'
import AddRoundedIcon from '@material-ui/icons/AddRounded'

const useStyles = makeStyles(() => ({
    root: {},
}))

const Header = (props) => {
    const { className, label, singularName, type, ...rest } = props

    const classes = useStyles()

    return (
        <div {...rest} className={clsx(classes.root, className)}>
            <Grid
                alignItems="flex-end"
                container
                justify="space-between"
                spacing={3}>
                <Grid item>
                    <Typography component="h2" gutterBottom variant="overline">
                        Content
                    </Typography>
                    <Typography component="h1" variant="h3">
                        {label.name}
                    </Typography>
                </Grid>
                {
                    checkPermission(type + '_create') &&
                    < Grid item>
                        <Tooltip title="Add new" aria-label="add-new">
                            <Link to={`/post-type/${type}/new`}>
                                <Fab style={{ marginLeft: 8 }} size="small" color="primary" aria-label="add">
                                    <AddRoundedIcon />
                                </Fab>
                            </Link>
                        </Tooltip>
                    </Grid>
                }

            </Grid>
        </div >
    )
}

Header.propTypes = {
    className: PropTypes.string,
    label: PropTypes.object.isRequired
}

Header.defaultProps = {
    label: {
        name: '...',
        singularName: '...',
    }
}


export default Header
