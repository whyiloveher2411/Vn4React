import { colors, Typography } from '@material-ui/core'
import { makeStyles } from '@material-ui/styles'
import Markdown from 'components/Markdown'
import { PageHeaderSticky } from 'components/Page'
import React, { useEffect, useState } from 'react'

const useStyles = makeStyles((theme) => ({
    markdownContainer: {
        maxWidth: 700,
        color: theme.palette.text.primary,
    },
}))

const Changelog = () => {
    const classes = useStyles()

    const [source, setSource] = useState('')

    useEffect(() => {
        fetch('/docs/Changelog.md')
            .then((response) => response.text())
            .then((text) => setSource(text))
    }, [])

    return (
        <PageHeaderSticky
            className={classes.root}
            title="Changelog"
            header={
                <>
                    <Typography gutterBottom variant="overline">
                        Support
                    </Typography>
                    <Typography variant="h3">Changelog</Typography>
                </>
            }
        >
            {source && (
                <div className={classes.markdownContainer}>
                    <Markdown
                        escapeHtml={false}
                        source={source} //
                    />
                </div>
            )}
        </PageHeaderSticky>
    )
}

export default Changelog
