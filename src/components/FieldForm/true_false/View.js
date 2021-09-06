import { Switch } from '@material-ui/core'
import React from 'react'

function View(props) {
    
    return (
        <Switch
            color="primary"
            checked={Boolean(props.content * 1 === 1)}
        />
    )
}

export default View
