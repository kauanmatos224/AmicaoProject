package com.example.amicacina;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import com.squareup.picasso.Picasso;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import java.util.ArrayList;

public class GridAdapter extends ArrayAdapter<GridModel> {
// Criando as variáveis para colocar as informações na activity_details.
    public static String nome,raca,nasc,idad,stat,gene,port,comp;


// Método requerido para usar o modelo da grid
    public GridAdapter(@NonNull Context context, ArrayList<GridModel> gridModelArrayList) {
        super(context, 0, gridModelArrayList);
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        View listitemView = convertView;
        // Se não tiver os dados, ele preenche a view com os dados
        if (listitemView == null) {

            // Infla o layout para mostrar os items no GridView
            listitemView = LayoutInflater.from(getContext()).inflate(R.layout.card_item, parent, false);
        }
        // Objeto do modelo da grid recebe o valor contido na posição definida no grid
        GridModel gridModel = getItem(position);

        // Instanciando os campos de informações (textos e a foto)
        TextView nameTV = listitemView.findViewById(R.id.idTVname);
        TextView racaTV= listitemView.findViewById(R.id.idTVraca);
        TextView nascTV= listitemView.findViewById(R.id.idTVnasc);
        TextView idadTV= listitemView.findViewById(R.id.idTVidad);
        TextView statTV= listitemView.findViewById(R.id.idTVstat);
        TextView geneTV= listitemView.findViewById(R.id.idTVgene);
        TextView portTV= listitemView.findViewById(R.id.idTVport);
        TextView compTV= listitemView.findViewById(R.id.idTVcomp);
        ImageView petIV = listitemView.findViewById(R.id.GVimg);

        // Usa métodos existentes no GridModel para pegar os dados do banco de dados e os posicionar em seus devidos campos
        nameTV.setText(gridModel.getpet_name());
        racaTV.setText(gridModel.getPet_raca());
        nascTV.setText(gridModel.getPet_nasc());
        idadTV.setText(gridModel.getPet_idad());
        statTV.setText(gridModel.getPet_stat());
        geneTV.setText(gridModel.getPet_gene());
        portTV.setText(gridModel.getPet_port());
        compTV.setText(gridModel.getPet_comp());
        // Usa a biblioteca Picasso para pegar a imagem no banco de dados
        Picasso.get().load(gridModel.getImgid()).into(petIV);

        /*
        nome = nameTV.getText().toString();
        raca = racaTV.getText().toString();
        nasc = nascTV.getText().toString();
        idad = idadTV.getText().toString();
        stat = statTV.getText().toString();
        gene = geneTV.getText().toString();
        port = portTV.getText().toString();
        comp = compTV.getText().toString();
*/
        return listitemView;
    }
}
