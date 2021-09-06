import { Button, Typography } from '@material-ui/core'
import React from 'react'
import { MaterialIcon } from 'components';

function Download({ message }) {
    return (
        <>
            <Typography gutterBottom>{message.download.title}</Typography>
            <Button size="small" style={{ padding: 0, textTransform: 'none', }} download href={message.download.link}>
                <MaterialIcon icon={'CheckCircle'} style={{
                    fontSize: 20,
                    color: '#b3b3b3',
                    paddingRight: 4,
                }} />
                {message.download.button}
            </Button>
        </>
    )
}

export default Download
