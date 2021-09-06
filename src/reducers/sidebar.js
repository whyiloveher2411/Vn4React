import * as sidebar from '../actions/sidebar'

let sidebarInitial = null;
try {
    sidebarInitial = JSON.parse(localStorage.getItem('sidebar')) || null;
} catch (error) {
}

const sidebarReducer = (state = sidebarInitial, action) => {

    switch (action.type) {
        case sidebar.UPDATE:
            
            if( state ){
                Object.keys( action.payload ).forEach( key =>{
                    if(  state[key] && state[key].show  ){
                        action.payload[key].show = true;
                    }
                });
            }
            localStorage.setItem("sidebar", JSON.stringify(action.payload));
            return {...action.payload};
        case sidebar.SHOW:
            // console.log(action);
            state[action.payload.index].show = action.payload.value;
            localStorage.setItem("sidebar", JSON.stringify(state));
            return { ...state };
        default:
            return state;
    }
}

export default sidebarReducer;