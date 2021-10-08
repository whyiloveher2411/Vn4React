import * as pluginsAction from '../actions/plugins';
import { plugins } from 'utils/plugin';

let pluginsInitial = plugins();

const pluginsReducer = (state = pluginsInitial, action) => {

    switch (action.type) {
        case pluginsAction.UPDATE:

            Object.keys(action.payload).forEach(key => {
                state[key] = action.payload[key];
            });

            let sortable = [];

            Object.keys(state).forEach(key => {
                sortable.push([key, state[key].priority ?? 99]);
            });

            sortable.sort(function (a, b) {
                return a[1] - b[1];
            });

            let newState = {};

            sortable.forEach(item => {
                newState[item[0]] = state[item[0]];
            });

            localStorage.setItem("plugins", JSON.stringify(newState));
            return newState;

            break;
        default:
            return state;
            break;
    }
}

export default pluginsReducer;