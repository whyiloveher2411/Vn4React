import React from 'react'
import { TextField } from '@material-ui/core';

export default React.memo(function LinkForm(props) {
    const { config, post, onReview, name, ...rest } = props;
    let valueInital = post && post[name] ? post[name] : '';

    const [value, setValue] = React.useState(0);

    console.log('render TEXT');

    return (
        <TextField
            fullWidth
            variant="outlined"
            name={name}
            value={valueInital}
            label={config.title}
            helperText={config.note}
            {...rest}
            onBlur={e => { onReview(e.target.value) }}
            onChange={e => { setValue(value + 1); post[name] = e.target.value }}
        />
    )
    
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})

