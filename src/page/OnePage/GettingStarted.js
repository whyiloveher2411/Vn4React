import React, { useEffect, useState } from 'react'
import { makeStyles } from '@material-ui/styles'
import { Typography, Divider, colors } from '@material-ui/core'

import { Page, Markdown } from '../../components'
import { Link } from 'react-router-dom'

const useStyles = makeStyles((theme) => ({
    root: {
        padding: theme.spacing(3, 3, 6, 3),
    },
    divider: {
        backgroundColor: colors.grey[300],
        marginTop: theme.spacing(1),
        marginBottom: theme.spacing(3),
    },
    markdownContainer: {
        maxWidth: 700,
    },
}))

const GettingStarted = (props) => {

    const classes = useStyles();

    const [source, setSource] = useState('')

    useEffect(() => {
        fetch('/docs/GettingStarted.md')
            .then((response) => response.text())
            .then((text) => setSource(text))
    }, [])

    return (
        <Page className={classes.root} title="Getting Started">
            <Typography gutterBottom variant="overline">
                Development
            </Typography>
            <Typography variant="h3">Getting Started</Typography>
            <Divider className={classes.divider} />
            {source && (
                <div className={classes.markdownContainer}>
                    <Markdown
                        escapeHtml={false}
                        source={source} //
                    />
                </div>
            )}
            <Link to="/input-field">Input Field</Link>
        </Page>
    )
}

export default GettingStarted
