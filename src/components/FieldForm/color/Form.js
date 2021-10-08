import { makeStyles } from '@material-ui/core'
import FormControl from '@material-ui/core/FormControl'
import IconButton from '@material-ui/core/IconButton'
import InputAdornment from '@material-ui/core/InputAdornment'
import InputLabel from '@material-ui/core/InputLabel'
import OutlinedInput from '@material-ui/core/OutlinedInput'
import ColorLensIcon from '@material-ui/icons/ColorLens'
import React from 'react'

const useStyles = makeStyles(() => ({
    inputHidden: {
        width: '100%',
        top: 0,
        position: 'absolute',
        bottom: 0,
        height: '100%',
        opacity: 0,
        cursor: 'pointer',
    },
}))

export default React.memo(function ColorForm(props) {
    const { config, post, onReview, name } = props;

    const classes = useStyles()
    const valueInital = post && post[name] ? post[name] : '';

    const [value, setValue] = React.useState(0);

    return (
        <FormControl size={config.size ?? 'medium'} fullWidth variant="outlined">
            {
                Boolean(config.title) ?
                    <>
                        <InputLabel>{config.title}</InputLabel>
                        <OutlinedInput
                            fullWidth
                            type='text'
                            style={{ color: valueInital }}
                            value={valueInital}
                            onBlur={e => { onReview(e.target.value) }}
                            onChange={e => { setValue(value + 1); post[name] = e.target.value }}
                            endAdornment={
                                <InputAdornment position="end">
                                    <IconButton
                                        aria-label="Color picker"
                                        edge="end"
                                    >
                                        <ColorLensIcon />
                                        <input className={classes.inputHidden} value={valueInital} onBlur={e => { onReview(e.target.value) }} onChange={e => { setValue(value + 1); post[name] = e.target.value }} type="color" />
                                    </IconButton>
                                </InputAdornment>
                            }
                            label={config.title}
                        />
                    </>
                    :
                    <OutlinedInput
                        fullWidth
                        type='text'
                        style={{ color: valueInital }}
                        value={valueInital}
                        onBlur={e => { onReview(e.target.value) }}
                        onChange={e => { setValue(value + 1); post[name] = e.target.value }}
                        endAdornment={
                            <InputAdornment position="end">
                                <IconButton
                                    aria-label="Color picker"
                                    edge="end"
                                >
                                    <ColorLensIcon />
                                    <input className={classes.inputHidden} value={valueInital} onBlur={e => { onReview(e.target.value) }} onChange={e => { setValue(value + 1); post[name] = e.target.value }} type="color" />
                                </IconButton>
                            </InputAdornment>
                        }
                    />
            }

        </FormControl>
    )
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})

