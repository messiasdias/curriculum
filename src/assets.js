import "./sass/main.scss"
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'

import { 
    faTimes, 
    faEnvelope,
    faPrint,
} 
from '@fortawesome/free-solid-svg-icons'

import { fab } from '@fortawesome/free-brands-svg-icons'

library.add(
    faTimes,
    faEnvelope,
    faPrint,
    fab,
)


export default FontAwesomeIcon
