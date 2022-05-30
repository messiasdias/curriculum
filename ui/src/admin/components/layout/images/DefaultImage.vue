<script>
import DefaultForm from './../../../commom/DefaultForm'
export default {
    name: "DefaultImage",
    extends: DefaultForm,
     data(){
        return {
            itemsTables: {
                "categories": "Categorias",
                "cases": "Cases",
                "solutions": "Soluções",
                "sliders": "Slides"
            }
        }
    },
     methods: {
        getTableItem(image){
            if (image.categorie && image.item_table == 'categories') return image.categorie
            if (image.case && image.item_table == 'cases') return image.case
            if (image.user && image.item_table == 'users') return image.user
            if (image.solution && image.item_table == 'solutions') return image.solution
            if (image.slide && image.item_table == 'sliders') return image.slide
        }
     }
}
</script>