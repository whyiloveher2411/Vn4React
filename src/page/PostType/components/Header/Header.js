import React from 'react'
import PropTypes from 'prop-types'
import clsx from 'clsx'
import { makeStyles } from '@material-ui/styles'
import { Grid, Typography, Button } from '@material-ui/core'

const useStyles = makeStyles(() => ({
    root: {},
}))

const Header = (props) => {
    const { className,label,singularName, ...rest } = props

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
                        Content sdf sdf sdf sdf 
                    </Typography>
                    <Typography component="h1" variant="h3">
                        {label.name}
                    </Typography>
                </Grid>
                <Grid item>
                    <Button color="primary" variant="contained">
                        Add {label.singularName}
                    </Button>
                </Grid>
            </Grid>
        </div>
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
sfdsdf

export default Header
