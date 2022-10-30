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

    public static String nome,raca,nasc,idad,stat,gene,port,comp,img;
    //public static int id;


    public GridAdapter(@NonNull Context context, ArrayList<GridModel> gridModelArrayList) {
        super(context, 0, gridModelArrayList);
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        View listitemView = convertView;
        if (listitemView == null) {
            // Layout Inflater inflates each item to be displayed in GridView.
            listitemView = LayoutInflater.from(getContext()).inflate(R.layout.card_item, parent, false);
        }
        GridModel gridModel = getItem(position);
        //id = position;

        //TextView idTV = listitemView.findViewById(R.id.idTVid);
        TextView nameTV = listitemView.findViewById(R.id.idTVname);
        TextView racaTV= listitemView.findViewById(R.id.idTVraca);
        TextView nascTV= listitemView.findViewById(R.id.idTVnasc);
        TextView idadTV= listitemView.findViewById(R.id.idTVidad);
        TextView statTV= listitemView.findViewById(R.id.idTVstat);
        TextView geneTV= listitemView.findViewById(R.id.idTVgene);
        TextView portTV= listitemView.findViewById(R.id.idTVport);
        TextView compTV= listitemView.findViewById(R.id.idTVcomp);
        ImageView petIV = listitemView.findViewById(R.id.GVimg);


        nameTV.setText(gridModel.getpet_name());
        racaTV.setText(gridModel.getPet_raca());
        nascTV.setText(gridModel.getPet_nasc());
        idadTV.setText(gridModel.getPet_idad());
        statTV.setText(gridModel.getPet_stat());
        geneTV.setText(gridModel.getPet_gene());
        portTV.setText(gridModel.getPet_port());
        compTV.setText(gridModel.getPet_comp());
        Picasso.get().load(gridModel.getImgid()).into(petIV);

/*
        nameTV.setText(MainActivity.nome[MainActivity.pos]);
        racaTV.setText(MainActivity.raca[MainActivity.pos]);
        nascTV.setText(MainActivity.nasc[MainActivity.pos]);
        idadTV.setText(MainActivity.idad[MainActivity.pos]);
        statTV.setText(MainActivity.stat[MainActivity.pos]);
        geneTV.setText(MainActivity.gene[MainActivity.pos]);
        portTV.setText(MainActivity.port[MainActivity.pos]);
        compTV.setText(MainActivity.comp[MainActivity.pos]);
        petIV.setImageResource(gridModel.getImgid());
*/
        nome = nameTV.getText().toString();
        raca = racaTV.getText().toString();
        nasc = nascTV.getText().toString();
        idad = idadTV.getText().toString();
        stat = statTV.getText().toString();
        gene = geneTV.getText().toString();
        port = portTV.getText().toString();
        comp = compTV.getText().toString();
        //img = petIV.getImageResource();

        return listitemView;
    }
}
